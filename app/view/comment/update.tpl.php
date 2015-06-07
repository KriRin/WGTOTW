<div class='comment-form'>  
    <form method=post>  
        <input type=hidden name="redirect" value="<?=$this->url->create($page)?>"> 
        <input type='hidden' name="page" value="<?= $page ?>"> 
        <input type='hidden' name='id' value='<?=$id?>'/>
        <fieldset>  
            <legend>Edit your comment</legend>  
            <label>Comment:<br><textarea name='content'><?= $info['content'] ?></textarea></label><br>  
            <label>Name:<br><input type='text' name='name' value='<?= $info['name'] ?>'/></label><br>  
            <label>Homepage:<br><input type='text' name='web' value='<?= $info['web'] ?>'/></label><br>  
            <label>Email:<br><input type='text' name='mail' value='<?= $info['email'] ?>'/></label>  
            <div class=buttons>
                <input type='submit' name='doSave' value='Save' onClick="this.form.action = '<?= $this->url->create('comment/save') ?>'"/>  
            </div>  
        </fieldset>  
    </form>  
</div>
