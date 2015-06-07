<?php

namespace Mos\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    protected $comments;

/**
 * Initialize the controller.
 *
 * @return void
 */
public function initialize() {
    $this->comments = new \Mos\Comment\Comments();
    $this->comments->setDI($this->di);
}



public function viewAction($page = null) {
    $this->initialize();
    
    $all = $this->comments->findAllComments($page);
    $this->views->add('comment/comments', [
            'comments' => $all,
            'page' => $page,
        ]);
}


/**
 * pid value is only sent to help redirect.
 */
public function createAction($id = null, $QuestionID = null) {
    $this->initialize();

    if($this->session->has('userid')) {
        
        $form = $this->form->create([], [
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Fråga:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'id' => [
                'type'        => 'hidden',
                'value'       => $id,
                'required'    => false,
            ],
            'Spara' => [
                'type'      => 'submit',
                'callback'  => function ($form) {
                    $now = gmdate('Y-m-d H:i:s');
                    
                    return $this->comments->save([
                        'content' => $this->form->value('content'),
                        'userid' => $this->session->get('userid'),
                        'Pid' => $this->form->value('id'),
                        'timestamp' => $now,
                        ]);
                    }
            ],
            'Reset' => [
                'type' => 'reset',
            ],
        ]);
        
        $status = $this->form->check();
        
        if ($status === true) {
            if(isset($QuestionID)) {
                $url = $this->url->create('posts/viewQuestion/' . $QuestionID);
            }
            else {
                $url = $this->url->create('posts/viewQuestion/' . $id);
            }
            $this->response->redirect($url);
        }

        

        $this->views->add('comment/form', [
            'content' => $form->getHTML(),
        ]);
        
    }

    else {
        $this->views->add('post/form', [
            'content' => "Du måste vara inloggad för att fråga/svara",
        ]);
    }


}



public function saveAction($id = null) {
    $updatedComment = [
            'content' => $this->request->getPost('content'),
            'name' => $this->request->getPost('name'),
            'web' => $this->request->getPost('web'),
            'mail' => $this->request->getPost('mail'),
            'page' => $this->request->getPost('page'),
            'id' => $this->request->getPost('id'),
        ];
    $comments->save([$updatedComment]);
    $this->response->redirect($this->request->getPost('redirect'));
}







}
