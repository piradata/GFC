<?php
require_once ('creds.php');
require_once ('auth_functions.php');

//This variable will be evaluated at the end of this file to check if a user is authenticated
$logged_in = false;


//session.cookie_path = "/torque/";
session_set_cookie_params(0,dirname($_SERVER['SCRIPT_NAME']));
session_start();

if (!isset($_SESSION['torque_logged_in'])) {
    $_SESSION['torque_logged_in'] = false;
}
$logged_in = (boolean)$_SESSION['torque_logged_in'];

//There are two ways to authenticate for Open Torque Viewer
//The uploading data provider running on Android uses its torque ID, while the User Interface uses User/Password.
//Which method will be chosed depends on the variable set before including this file
// Set "$auth_user_with_torque_id" for Authetification with ID
// Set "$auth_user_with_user_pass" for Authetification with User/Password
// Default is authentication with user/pass

if(!isset($auth_user_with_user_pass)) {
    $auth_user_with_user_pass = true;
}

if (!$logged_in && $auth_user_with_user_pass)
{
    if ( auth_user() ) {
        $logged_in = true;
    }
}

//ATTENTION:
//The Torque App has no way to provide other authentication information than its torque ID.
//So, if no restriction of Torque IDs was defined in "creds.php", access to the file "upload_data.php" is always possible.

if(!isset($auth_user_with_torque_id)) {
    $auth_user_with_torque_id = false;
}

if (!$logged_in && $auth_user_with_torque_id)
{
    if ( auth_id() )
    {
        $session_id = get_id();
        $logged_in = true;
    }
}


$_SESSION['torque_logged_in'] = $logged_in;

if (!$logged_in) {
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TELEMETRIA</title>
        <meta name="description" content="Open Torque Viewer">
        <meta name="author" content="Matt Nicklay">
        <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
		<link rel="stylesheet" type="text/css" href="static/css/bootstrap.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script language="javascript" type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script language="javascript" type="text/javascript" src="static/js/jquery.peity.min.js"></script>
        <script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
    </head>
    <body>
        <div role="navigation" align="middle" style="background-color:black">
            <div align="middle">
                <div>
                    <a href="auth_user.php" style="font-size:50px;color:white;" >TELEMETRIA ALPHA</a>
                </div>
                <div>
                    <div>
                        <h3 style="color:white;font-weight:bold;">Login</h3>
                        <div style="padding-bottom:4px;">
                            <form method="post" class="form-horizontal" role="form" action="session.php" id="formlogin">
                                <input class="btn btn-info btn-sm" type="text" name="user" value="" placeholder="(Usuario)" />
                                <input class="btn btn-info btn-sm" type="password" name="pass" value="" placeholder="(Senha)" />
                                <input class="btn btn-info btn-sm" type="submit" id="formlogin" name="Login" value="Entrar" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
    exit(0);
}
else
{
    //Prepare session
    
    //Connect to Sql, ...
}

?>