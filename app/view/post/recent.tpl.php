<h2>Senaste frågorna</h2>
<div>
<?php foreach ($questions as $question) : ?>
<?php $info = $question->getProperties();?>
    <?php $ans = 0; ?>
    <?php foreach($answers as $answer) : ?>
        <?php $Q = $answer->getProperties(); ?>
        <?php if($Q['QuestionID'] == $info['id']) : ?>
            <?php $ans++; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class='question'>
        <form method='post'>
            <div class="qcontent nounderline">
                <h3><a href="<?=$this->url->create('posts/viewQuestion/'.$info['id'])?>"><?=$info['title']?></a></h3>
                <p><?=$info['content']?></p>
                <span><b>Svar:</b> <?=$ans?></span><br/>
                <span><b>Taggar:</b> <?=$info['tags']?></span>
            </div>
            <div class="user nounderline">
                <img src="http://www.gravatar.com/avatar/774e706c6ba6b4270e562abe9e4c3a47.jpg?s=90&d=mm" alt="gravatar">
                <strong><a href="<?=$this->url->create('users/id' . '/' . $info['userid'])?>"><?=$info['username']?></a></strong>
            </div>
            <input type='hidden' name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
        </form>
    </div>
<?php endforeach; ?>
</div>
    
    
    

<div class='tags nounderline'>
<h2>Mest populära taggar</h2>
<?php
$taggar = array();

foreach($tags as $tag) {
    $info = $tag->getProperties();
    $etag = explode(',', $info['tags']);
    foreach($etag as $ftag) {
        $taggar[] = $ftag;
    }
}
$taggar = array_count_values($taggar);
arsort($taggar);
$taggar = array_slice($taggar, 0, 5);


foreach($taggar as $tag => $val) {
    $url = $this->url->create('posts/viewOneTag/' . $tag);

    echo <<<EOD
        <a href="$url">($val)$tag</a>
EOD;

}
?>

<hr>
</div>
