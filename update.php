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
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 10
            )
        ));
        if ($validate->passed()) {
            try {
                $user->update(array(
                    'name' => Input::get('name')
                ));
                Session::flash('home', 'Your deatils were updated');
                Redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error.'<br>';
            }
        }
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="<?php echo escape($user->data()->name); ?>">

        <input type="submit" value="Update">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </div>
</form>