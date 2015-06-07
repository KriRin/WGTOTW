<h1><?=$title?></h1>

<article>
    
<?php 
if($user == true) {
    
    $info = $user->getProperties();

    $url_update = $this->url->create('users/update/' . $info['id']);
    $url_delete = $this->url->create('users/delete/' . $info['id']);


    echo <<<EOD
        <div>
            <img src="http://www.gravatar.com/avatar/774e706c6ba6b4270e562abe9e4c3a47.jpg?s=150&d=mm" alt="gravatar">
            <h3>{$info['username']}</h3>
            <p><b>Namn:</b> {$info['name']}</p>
            <p><b>Email:</b> {$info['email']}</p>
            <p><b>Medlem sedan:</b> {$info['created']}</p>
        </div>
EOD;
}


else {
echo "<p>Det finns ingen användare med detta id.</p>";
}

?>
<br/>
<?php if($auth) : ?>
    <p><a href="<?=$url_update?>">updatera</a> | <a href="<?=$url_delete?>">radera</a></p>
    <br/>
<?php endif; ?>


<?php
if($user == true) {
    foreach($posts as $post) {
        $info = $post->getProperties();
        $words = explode(' ', $info['content']);
        $count = 10;
        if (count($words) > $count){
        $words = array_slice($words, 0, $count);
        $string = implode(' ', $words);
        }
        else {
            $string = implode(' ', $words);
        }
        if($info['posttype'] == 2) {
            $question_link = $this->url->create('posts/viewQuestion/' . $info['QuestionID']);
        }
        else {
            $question_link = $this->url->create('posts/viewQuestion/' . $info['id']);
        }
        echo <<<EOD
            <h2>Senaste frågor/svar:</h2>
            <hr/>
            <strong>{$info['title']}</strong>
            <p>{$string}<a href="{$question_link}">..  mer</a></p>
EOD;
    }
}
?>

</article> 


