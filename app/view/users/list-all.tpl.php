<h1><?=$title?></h1>

<table class="usertable">
    <tr>
        <th>Användarnamn</th>
        <th>Namn</th>
        <th>Email</th>
    </tr>

<?php foreach ($users as $user) {


$info = $user->getProperties();

$url = $this->url->create('users/id/' . $info['id']);
$url_update = $this->url->create('users/update/' . $info['id']);
$url_delete = $this->url->create('users/softDelete/' . $info['id']);



echo <<<EOD

    <tr>
        <td><a href="$url">{$info['username']}</a></td>
        <td>{$info['name']}</td>
        <td>{$info['email']}</td>
       
    </tr>
EOD;
}
?>
</table>

<?php if(empty($this->session->has('userid'))) : ?>
<p><a href='<?=$this->url->create('users/add')?>'>Bli medlem</a></p> 
<?php endif; ?>
