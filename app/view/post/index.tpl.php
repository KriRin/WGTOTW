<h2>Fråga:</h2>
<div class='question'>
<?php foreach ($question as $post) : ?>
    <?php $info = $post->getProperties();?>
    <form method='post'>
        <div class="qcontent nounderline">
            
            <h3><?=$info['title']?></h3>
            <p><?=$this->di->textFilter->doFilter($info['content'], 'shortcode, markdown');?></p>
            <p><b>Taggar:</b> <?=$info['tags']?></p>
        </div>
        <div class="user nounderline">
            <img src="http://www.gravatar.com/avatar/774e706c6ba6b4270e562abe9e4c3a47.jpg?s=90&d=mm" alt="gravatar">
            <strong><a href="<?=$this->url->create('users/id' . '/' . $info['userid'])?>"><?=$info['username']?></a></strong>
        </div>
        <?php if($this->session->has('userid')) : ?>
        <div class="answ_comtbutton">
            <input type='hidden' name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
            <input class='answ_comtbutton' type='submit' name='doCreate' value='Svara' onClick="this.form.action = '<?=$this->url->create('posts/createPost/'. 2 . '/'. $info['id'])?>'"/>
            <input class='answ_comtbutton' type='submit' name='doComment' value='Kommentera' onClick="this.form.action = '<?=$this->url->create('comment/create/'. $info['id'])?>'"/>
        </div>
        <?php endif; ?>
    </form>
</div>
<div class="comments">
    <?php foreach ($comments as $comment) : ?>
        <?php $comt = $comment->getProperties();?>
        <?php if($comt['Pid'] == $info['id']) :?>
            <p class='comment'><?=$this->di->textFilter->doFilter($info['content'], 'shortcode, markdown');?></p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endforeach; ?>
</div>




<h2>Svar:</h2>
<div class='answers'>
<?php foreach ($answers as $answer) : ?>
<?php $info = $answer->getProperties();?>
    <form class='answer' method='post'>
        <div class="qcontent nounderline">
            <p><?=$this->di->textFilter->doFilter($info['content'], 'shortcode, markdown');?></p>
        </div>
        <div class="user nounderline">
            <img src="http://www.gravatar.com/avatar/774e706c6ba6b4270e562abe9e4c3a47.jpg?s=90&d=mm" alt="gravatar">
            <strong><a href="<?=$this->url->create('users/id' . '/' . $info['userid'])?>"><?=$info['username']?></a></strong>
        </div>
        <div class="answ_comtbutton">
            <input type='hidden' name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
            <?php if($this->session->has('userid')) : ?>
            <input class='answ_comtbutton' type='submit' name='doComment' value='Kommentera' onClick="this.form.action = '<?=$this->url->create('comment/create/'. $info['id'] . '/' . $info['QuestionID'])?>'"/>
            <?php endif; ?>
        </div>
    </form>
</div>
<div class="comments">
    <?php foreach ($comments as $comment) : ?>
        <?php $comt = $comment->getProperties();?>
        <?php if($comt['Pid'] == $info['id']) :?>
            <p class='comment'><?=$this->di->textFilter->doFilter($comt['content'], 'shortcode, markdown');?></p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endforeach; ?>
</div>
