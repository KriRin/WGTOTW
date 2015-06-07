<?php

require __DIR__.'/config_with_app.php'; 


$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


// Set the title of the page
$app->theme->setVariable('title', "WGTOTW");

// set the navbar
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');

$app->theme->configure(ANAX_APP_PATH . 'config/theme.php');




$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Hem");
    
    $app->dispatcher->forward([ 
        'controller' => 'posts', 
        'action'     => 'viewFront',
    ]);
    
    $app->dispatcher->forward([ 
        'controller' => 'users', 
        'action'     => 'viewFront',
    ]);

});




$app->router->add('about', function() use ($app) {

  $app->theme->setTitle("Om oss");

  $content = $app->fileContent->get('about.md');
  $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

  $byline = $app->fileContent->get('byline.md');
  $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

  $app->views->add('default/page', [
    'content' => $content,
    'byline' => $byline,
    ]);
});




$app->router->add('source', function() use ($app) {
    
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('default/source', [
        'content' => $source->View(),
    ]);
 
});




// route for setting up the db table and adding default users and comments
$app->router->add('setup', function() use ($app) {
 
    //$app->db->setVerbose();
 
    $app->db->dropTableIfExists('users')->execute();
 
    $app->db->createTable(
        'users',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'username' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
        ]
    )->execute();
    
    
    
    $app->db->insert(
        'users',
        ['username', 'email', 'name', 'password', 'created']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now
    ]);
 
    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
    ]);



// part for setting up table for comments
//
    $app->db->dropTableIfExists('comments')->execute();
 
    $app->db->createTable(
        'comments',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'Pid' => ['integer', 'not null'],
            'userid' => ['integer', 'not null',],
            'content' => ['text'],
            'timestamp' => ['datetime'],
        ]
    )->execute();
    
    
    
    $app->db->insert(
        'comments',
        ['content', 'Pid', 'userid','timestamp',]
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'Första kommentaren :)',
        '1',
        '2',
        $now,
    ]);

    $app->db->execute([
            'Andra kommentaren',
            '1',
            '2',
            $now,
        ]);



    //Questions and answers--------------

    $app->db->dropTableIfExists('posts')->execute();
 
    $app->db->createTable(
        'posts',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'QuestionID' => ['integer'],
            'posttype' => ['integer', 'not null'],
            'title'     => ['text'],
            'tags'      => ['text'],
            'userid' => ['integer', 'not null',],
            'username' => ['text'],
            'content' => ['text'],
            'timestamp' => ['datetime'],
        ]
    )->execute();
    
    
    
    $app->db->insert(
        'posts',
        ['title', 'content', 'posttype', 'QuestionID', 'userid', 'username', 'tags', 'timestamp',]
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'Den första frågan',
        'Detta är type 1, en fråga',
        '1',
        null,
        '2',
        'doe',
        'first,cool',
        $now,
    ]);

    $app->db->execute([
        null,
        'Denna har en type 2 och är därför ett svar',
        '2',
        '1',
        '2',
        'doe',
        null,
        $now,
        ]);





    $app->views->addString('Återställde databasen med ett par exempel poster.');

});









 
$app->router->handle();
$app->theme->render();

