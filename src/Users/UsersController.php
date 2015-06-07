<?php
namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
 
    protected $users;
    protected $posts;
    protected $reuse;




/**
 * Initialize the controller.
 *
 * @return void
 */
public function initialize()
{
    $this->users = new \Anax\Users\Users();
    $this->users->setDI($this->di);
    $this->posts = new \Krri\Posts\Posts();
    $this->posts->setDI($this->di);
}



/**
 * List all users.
 *
 * @return void
 */
public function listAction()
{
    $all = $this->users->findAll();
    
    $this->theme->setTitle("List all users");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Alla användare",
    ]);
}



/**
 * Add new user.
 *
 * @param string $username of user to add.
 *
 * @return void
 */
public function addAction() {
    $this->initialize();
    $formular = $this->form->create([], [
        'username' => [
            'type'        => 'text',
            'label'       => 'Användarnamn:',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'name' => [
            'type'        => 'text',
            'label'       => 'Namn:',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'email' => [
            'type'        => 'text',        
            'label'       => 'E-post:',            
            'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
        ],
        'password' => [
            'type'        => 'password',
            'label'       => 'Lösenord:',            
            'required'    => true,
            'validation'  => ['not_empty'],
        ],        
        'Spara' => [
            'type'      => 'submit',
            'callback'  => function ($formular) {
                $this->form->saveInSession = false;
                return true;
            }
        ],

    ]);


    $status = $this->form->check();
    $url = $this->url->create('users/list');
    if ($status === true) {
        //check for none duplicate usernames
        if(!$this->noneDuplicate($this->form->value('username'))) {
            $now = date('Y-m-d H:i:s');
            $this->users->save([
                'username' => $this->form->value('username'),
                'name' => $this->form->value('name'),
                'email' => $this->form->value('email'),
                'password' => password_hash($this->form->value('password'), PASSWORD_DEFAULT),
                'created' => $now,
            ]);
        }
        else {
            $this->form->AddOutput("Användarnamn finns redan, välj ett annat.");
            $this->response->redirect($this->di->request->getCurrentUrl());
        }
        //$url = $this->url->create('users/id/' . $this->users->id);
        $this->response->redirect($url);
        //check for none duplicate usernames else clause.

    }
    
    else if ($status === false) {
        $this->form->AddOutput("Ett fel uppstod. Se felmeddelandena ovan.");
        $this->response->redirect($this->di->request->getCurrentUrl());
    }
    
    $this->views->add('default/page', [
        'title' => "Lägg till användare",
        'content' => $this->form->getHTML(),
    ], 'main');
}



/**
 * Delete user.
 *
 * @param integer $id of user to delete.
 *
 * @return void
 */
public function deleteAction($id = null) {
    if($this->checkAuthenticated($id)) {
        if (!isset($id)) {
            die("Missing id");
        }
     
        $res = $this->users->delete($id);
     
        $this->logoutAction();
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }
    
    // If user is not logged in.
    else {
        $this->views->add('default/page', [
        'title' => "Fel användare",
        'content' => "Du har inte rättigheter att ändra denna användares profil",
        ], 'main');
    }
}



/**
 * List user with id.
 *
 * @param int $id of user to display
 *
 * @return void
 */
public function idAction($id = null)
{
    $user = $this->users->find($id);
    $posts = $this->posts->findUsersPosts($id);
    $auth = $this->checkAuthenticated($id);
    
    $this->theme->setTitle("Visa användare med id");   
    $this->views->add('users/view', [
        'user' => $user,
        'posts' => $posts,
        'auth' => $auth,
        'title' => "Profil",
    ]);
    
}



public function viewFrontAction() {
    $mostposts = $this->posts->findMostActUsers();
    $users = $this->users->findAll();
    
    $this->views->add('users/recent', [
        'mostposts' => $mostposts,
        'users' => $users,
        'title' => "Mest aktiva användare",
    ]);
}

/**
 * Update user.
 *
 * @param string $id of user to update.
 *
 * @return void
 */
public function updateAction($id = null) {
    $this->initialize();
    
    // If user is logged in.
    if($this->checkAuthenticated($id)) {
        $user = $this->users->find($id);
        $info = $user->getProperties();
        $id = isset($info['id']) ? $info['id'] : null;
        $name = isset($info['name']) ? $info['name'] : null;
        $email = isset($info['email']) ? $info['email'] : null;

        $form = $this->form->create([], [
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn:',
                'value'       => $name,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'text',
                'label'       => 'E-post:',
                'value'       => $email,
                'required'    => true,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'password' => [
                'type'        => 'password',
                'label'       => 'Nytt lösenord:',
                'required'    => false,
                'validation'  => ['pass'],
            ],        
            'Spara' => [
                'type'      => 'submit',
                'callback'  => function ($formular) {
                    $this->form->saveInSession = true;
                    return true;
                }
            ],

        ]);   
        
        $status = $this->form->check();

        if ($status === true) {
                $now = date('Y-m-d H:i:s');
                $this->users->save([
                    'id' => $id,
                    'email' => $this->form->value('email'),
                    'name' => $this->form->value('name'),
                    'password' => password_hash($this->form->value('password'), PASSWORD_DEFAULT),
                ]);
                
            $url = $this->url->create('users/id/' . $this->users->id);
            $this->response->redirect($url);
        }
        else if ($status === false) {
                $this->form->AddOutput("Ett fel uppstod. Se felmeddelandena ovan.");
                $this->response->redirect($url);
                header("Location: " . $this->di->request->getCurrentUrl());
        }
    
        $this->views->add('default/page', [
            'title' => "Uppdatera profil",
            'content' => $this->form->getHTML(),
        ], 'main');
    }
    
    // If user is not logged in.
    else {
            $this->views->add('default/page', [
            'title' => "Fel användare",
            'content' => "Du har inte rättigheter att ändra denna användares profil",
        ], 'main');
    }
}



/**
 * Login to a useraccount.
 * 
 * Creates login form and sets sessionkey userid to the users id.
 * @return htmlform.
 */
public function loginAction() {
    $this->initialize();
    $formular = $this->form->create([], [
        'username' => [
            'type'        => 'text',
            'label'       => 'Användarnamn:',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'password' => [
            'type'        => 'password',
            'label'       => 'Lösenord:',            
            'required'    => true,
            'validation'  => ['not_empty'],
        ],        
        'Login' => [
            'type'      => 'submit',
            'callback'  => function ($formular) {
                $this->form->saveInSession = false;
                return true;
            }
        ],
    ]);


    $status = $this->form->check();
    if ($status === true) {
        //check if user exists
        if($this->users->findUN($this->form->value('username')) == true) {
            $user = $this->users->findUN($this->form->value('username'));
            $info = $user->getProperties();
            
            //check if password verifies
            if(password_verify($this->form->value('password'), $info['password'])) {
                $this->session->set('userid', $info['id']);
                $this->session->set('username', $info['username']);
                $this->response->redirect($this->url->create('users/id/' . $info['id']));
            }
            else {
                $this->form->AddOutput("Fel användarnamn eller lösenord.");
                header("Location: " . $this->di->request->getCurrentUrl());
                
            }
        }
        
        //If user doesn't exist
        else {
            $this->form->AddOutput("Fel användarnamn eller lösenord.");
            header("Location: " . $this->di->request->getCurrentUrl());
        }
    }
    
    else if ($status === false) {
            $this->form->AddOutput("Ett fel uppstod. Se felmeddelandena ovan.");
            header("Location: " . $this->di->request->getCurrentUrl());
    }
    
    $this->views->add('default/page', [
        'title' => "Logga in",
        'content' => $this->form->getHTML(),
    ], 'main');

}



/**
 * check whether person is logged and the right user.
 */
private function checkAuthenticated($id) {
    if(!empty($this->session->has('userid')) && $this->session->get('userid') == $id) {
        return true;
    }
    else {
        return false;
    }
}



/**
 * Logout from user. Unsets sessionkey userid.
 */
public function logoutAction() {
    $this->session->remove('userid');
    $this->session->remove('username');
    $url = $this->url->create('');
    $this->response->redirect($url);
}



/**
 * check for duplicate usernames in database
 */
private function noneDuplicate($username) {
    if(empty($this->users->findUN($username))) {
        return false;
    }
    else {
        return true;
    }
}



}
