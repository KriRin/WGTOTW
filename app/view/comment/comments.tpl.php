<h2>Comments</h2>
<div class='comments'>
<?php foreach ($comments as $comment) : ?>
<?php $info = $comment->getProperties();?>
    <form class='comment' method='post'>
        <strong><?=$info['name']?></strong><br>
        <strong>E-post: </strong><?=$info['email']?><br>
        <strong>Webbsida: </strong><?=$info['web']?><br>
        <p><?=$info['content']?></p>
        <input type='hidden' name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
        <input type='hidden' name='page' value='<?= $page ?>'>
        <input class='commentbutton' type='submit' name='doUpdate' value='&#9998;' onClick="this.form.action = '<?=$this->url->create('comment/update/'.$info['id'])?>'"/>
        <input class='commentbutton' type='submit' name='doDelete' value='&#10006;' onClick="this.form.action = '<?=$this->url->create('comment/delete/'.$info['id'])?>'"/>
    </form>
<?php endforeach; ?>
</div>
