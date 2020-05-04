<?php
require_once 'core/init.php';

/* $users = DB::getInstance()->query("SELECT * FROM users;");

if (!$users->count()) {
    echo 'error';
} else {
    echo $users->first()->username;
} */
// $insert = DB::getInstance()->insert('users', array(
//     'username' => 'oao',
//     'password' => 'passwordddd',
//     'salt' => 'salsda'
// ));

// $update = DB::getInstance()->update('users', 1, array(
//     'password' => 'newpwd',
//     'salt' => 'salsda'
// ));

if (Session::exists('home')) {
    echo '<p>'.Session::flash('home').'</p>';
}

$user = new User();
if ($user->isLoggedIn()) {
    ?>
    <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->id); ?>"><?php echo escape($user->data()->username); ?></a></p>

    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">Update details</a></li>
        <li><a href="changepassword.php">Change password</a></li>
    </ul>
    <?php

    if ($user->hasPermission('admin')) {
        echo '<p>You are an administrator</p>';
    }

    } else {
        echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
    }