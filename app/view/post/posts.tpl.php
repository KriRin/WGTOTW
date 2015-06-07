<h2>Questions</h2>
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
    
    
    
    <div class="question">
        <div class="qcontent nounderline">
            <h3><a href="<?=$this->url->create('posts/viewQuestion/'.$info['id'])?>"><?=$info['title']?></a></h3>
            <p><?=$info['content']?></p>
            <span>Svar: <?=$ans?></span><br/>
            <span><b>Taggar:</b> <?=$info['tags']?></span>
        </div>
        <div class="user nounderline">
            <img src="http://www.gravatar.com/avatar/774e706c6ba6b4270e562abe9e4c3a47.jpg?s=90&d=mm" alt="gravatar">
            <strong><a href="<?=$this->url->create('users/id' . '/' . $info['userid'])?>"><?=$info['username']?></a></strong>
        </div>
    </div>

<?php endforeach; ?>
</div>
