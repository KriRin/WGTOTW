<?php

namespace Krri\Posts;

/**
 * To attach posts-flow to a page or some content.
 *
 */
class PostsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    protected $posts;
    protected $comments;


/**
 * Initialize the controller.
 *
 * @return void
 */
public function initialize() {
    $this->posts = new \Krri\Posts\Posts();
    $this->posts->setDI($this->di);
    $this->comments = new \Mos\Comment\Comments();
    $this->comments->setDI($this->di);
}


/**
 * view all questions in a long list.
 */
public function viewAction() {
    $this->initialize();
    
    $questions = $this->posts->findAllposts(1);
    $answers = $this->posts->findAllposts(2);
    
    
    $this->views->add('post/posts', [
            'questions' => $questions,
            'answers' => $answers,
        ]);
}



public function viewOneTagAction($tag) {
    $this->initialize();
    $questions = $this->posts->findAllPostsWithTag($tag);
    $answers = $this->posts->findAllposts(2);
    
    $this->views->add('post/posts', [
            'questions' => $questions,
            'answers' => $answers,
        ]);
}



public function createPostAction($posttype = null, $id = null) {
    $this->initialize();
    
if($this->session->has('userid')) {

    if($posttype == 2) {
        $form = $this->form->create([], [
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Svar:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'posttype' => [
                'type'        => 'hidden',
                'value'       => $posttype,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'QuestionID' => [
                'type'        => 'hidden',
                'value'       => $id,
                'required'    => false,
            ],
            'Spara' => [
                'type'      => 'submit',
                'callback'  => function ($form) {
                    $now = gmdate('Y-m-d H:i:s');
                    
                    return $this->posts->save([
                        'content' => $this->form->value('content'),
                        'userid' => $this->session->get('userid'),
                        'username' => $this->session->get('username'),
                        'posttype' => $this->form->value('posttype'),
                        'QuestionID' => $this->form->value('QuestionID'),
                        'timestamp' => $now,
                        ]);
                    }
            ],
            'Reset' => [
                'type' => 'reset',
            ],
        ]);
    }//if ends
    
    else {
        $form = $this->form->create([], [
            'title' => [
                'type'        => 'text',
                'label'       => 'Titel:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Fråga:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'tags' => [
                'type'        => 'text',
                'label'       => 'Taggar: (Separera taggar med ett ",")',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'posttype' => [
                'type'        => 'hidden',
                'value'       => $posttype,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'QuestionID' => [
                'type'        => 'hidden',
                'value'       => $id,
                'required'    => false,
            ],
            'Spara' => [
                'type'      => 'submit',
                'callback'  => function ($form) {
                    $now = gmdate('Y-m-d H:i:s');
                    
                    return $this->posts->save([
                        'title' => $this->form->value('title'),
                        'content' => $this->form->value('content'),
                        'userid' => $this->session->get('userid'),
                        'username' => $this->session->get('username'),
                        'tags' => $this->form->value('tags'),
                        'posttype' => $this->form->value('posttype'),
                        'QuestionID' => $this->form->value('QuestionID'),
                        'timestamp' => $now,
                        ]);
                    }
            ],
            'Reset' => [
                'type' => 'reset',
            ],
        ]);
    } //else ends
    
    $status = $this->form->check();
    
    if ($status === true) {
            $url = $this->url->create('posts/view');
            $this->response->redirect($url);
    }
    
    $this->views->add('post/form', [
        'content' => $form->getHTML(),
    ]);
}//session if ends

else {
    $this->views->add('post/form', [
        'content' => "Du måste vara inloggad för att fråga/svara",
    ]);
}

}



public function saveAction($id = null) {
    $updatedComment = [
            'content' => $this->request->getPost('content'),
            'title' => $this->request->getPost('title'),
            'web' => $this->request->getPost('web'),
            'mail' => $this->request->getPost('mail'),
            'page' => $this->request->getPost('page'),
            'id' => $this->request->getPost('id'),
        ];
    $this->posts->save([$updatedComment]);
    $this->response->redirect($this->request->getPost('redirect'));
}



public function viewQuestionAction($id) {
    $this->initialize();
    
    $question = $this->posts->findQuestion($id);
    $answers = $this->posts->findAnswers($id);
    $comments = $this->comments->findComments($id);
    
    
    $this->views->add('post/index', [
            'question' => $question,
            'answers' => $answers,
            'comments' => $comments,
        ]);
}



public function viewTagsAction() {
    $this->initialize();
    $all = $this->posts->findAllPosts(1);
    
    $this->views->add('post/tags', [
        'posts' => $all,
    ]);
}



public function viewFrontAction() {
    $this->initialize();
    $questions = $this->posts->findLatestQuestions();
    $tags = $this->posts->findAllPosts('1');
    $answers = $this->posts->findAllposts(2);
    
    $this->views->add('post/recent', [
        'questions' => $questions,
        'tags' => $tags,
        'answers' => $answers,
    ]);
}





}
