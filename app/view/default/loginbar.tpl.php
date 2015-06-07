<?php
$url_login = $this->url->create('users/login');
$url_register = $this->url->create('users/add');
$url_name = $this->session->get('username');
$url_id = $this->url->create('users/id' . '/' . $this->session->get('userid'));
$url_logout = $this->url->create('users/logout');

if($this->session->has('userid')) {
echo <<<EOD
    <div class="loginbar">
    <a href="$url_logout">Logga ut</a>
    <strong> | </strong>
    <a href="$url_id">$url_name</a>
    </div>
EOD;
}

else {
echo <<<EOD
    <div class="loginbar">
    <a href="$url_login"?>Logga in</a>
    <strong> | </strong>
    <a href="$url_register">Registrera dig</a>
    </div>
EOD;
}

