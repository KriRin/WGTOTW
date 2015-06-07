<h2><?=$title?></h2>
<table class="usertable">
    <tr>
        <th>Användarnamn</th>
        <th>Namn</th>
        <th>Email</th>
    </tr>

<?php

$userids = array();
foreach($mostposts as $mostpost) {
    $info = $mostpost->getProperties();
    $userids[] = $info['userid'];
}

$userids = array_count_values($userids);
arsort($userids);
array_slice($userids, 0, 5);

foreach($userids as $usernr => $val) {
    foreach ($users as $user) {
        $info = $user->getProperties();
        if($info['id'] == $usernr) {
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
    }
}

?>
</table></article>
