# PHP-OOP-User_panel_v0.1
This is the most basic structure of PHP OOP user panel with register/login and group management functions.<br>
You can easily develop your project on this structure.<br>
<b>Free to use.</b>

<u>Structure:</u>
<pre>classes/ - contains all necessary classes
    |----Config.php - for fast access to global config variables
    |----Cookie.php - deals with Cookies
    |----DB.php - works with database (PDO)
    |----Hash.php - deals with hashing security
    |----Input.php - deals with POST/GET inputs
    |----Redirect.php - Redirects users
    |----Session.php - deals with session information
    |----Token.php - CSRF security
    |----User.php - deals with user information (create/modify/check premissions etc.)
    |----Validation.php - validates recieved info (e.g. from Input)
core/init.php - contains class autoloader with all necessary global variables
function/sanitize.php - contains functions
includes/errors/404.php - blank error page (could be redirected to via Redirect::to(404);)
xxx.php - name of the script represents its function
index.php - main script (kind of homepage)
</pre>

<i>Created on 04.05.2020</i>
