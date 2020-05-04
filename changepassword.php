<?php
require_once 'core/init.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            ),
        ));

        if ($validate->passed()) {
            if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
                echo 'You entered wrong current password';
            } else {
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));

                Session::flash('home', 'Your password has been changed');
                Redirect::to('index.php');
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error.'<br>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <div class="field">
            <label for="password_current">Current password</label>
            <input type="password" name="password_current" id="password_current">
        </div>
        <div class="field">
            <label for="password_new">New password</label>
            <input type="password" name="password_new" id="password_new">
        </div>
        <div class="field">
            <label for="password_new_again">Repeat your new password</label>
            <input type="password" name="password_new_again" id="password_new_again">
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Change">
    </form>
</body>
</html>