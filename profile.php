<?php
require_once 'core/init.php';

if (!$username = Input::get('user')) {
    Reditect::to('index.php');
} else {
    $user = new User($username);
    if (!$user->exists()) {
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
}
?>

<h3><?= $data->username?></h3>
<p>Full name: <?=$data->name ?></p>