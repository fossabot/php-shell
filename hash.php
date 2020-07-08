<?php




function stripslashes_deep($value) 
{
    if (is_array($value)) {
        return array_map('stripslashes_deep', $value);
    } else {
        return stripslashes($value);
    }
}

if (get_magic_quotes_gpc()) {
    $_POST = stripslashes_deep($_POST);
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

?>
<?php echo '<?xml version="1.0" ?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <title>Hash Password</title>
  <meta http-equiv="Content-Style-Type" content="text/css"/>
  <meta name="generator" content="phpshell"/>
  <link rel="shortcut icon" type="image/x-icon" href="https://firebasestorage.googleapis.com/v0/b/webtuhin.appspot.com/o/shell%2Ffavicon.ico?alt=media&token=5cd44a03-69c1-40f4-84e9-080deb284585"/>
  <link rel="stylesheet" href="https://firebasestorage.googleapis.com/v0/b/webtuhin.appspot.com/o/shell%2Fstyle.css?alt=media&token=766b8513-be3d-4a31-abc0-57bb97108538" type="text/css"/>
</head>

<body>

<h1>Hash Password</h1>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

<fieldset>
  <legend>Enter an Username and a Secure Password</legend>
  <label for="username">Username:</label>
  <input name="username" id="username" type="text" 
         value="<?php echo htmlspecialchars($username) ?>"/>
  
  <label for="password">Password:</label>
  <input name="password" id="password" type="text" 
         value="<?php echo htmlspecialchars($password) ?>"/>
</fieldset>

<fieldset>
  <legend>Result</legend>

<?php
if ($username == '' || $password == '') {
    echo '  <p><i>Enter an username and a password and update.</i></p><br/>';
} else {
    $u = strtolower($username);
    if (!preg_match('/^[[:alpha:]][[:alnum:]]*$/', $u)
        || in_array($u, array('null','yes','no','true','false','on','off', 'none'))
    ) {
        echo <<<END
<p class="error">Your username cannot be one of the following reserved words: 
'null', 'yes', 'no', 'true', 'false', 'on', 'off', 'none'.<br/>
It can contain only letters and digits and must start with a letter.<br/>
Please choose another username and try again.</p>
END;
    } else {
        echo "<p>Write the following line into <tt>config.php</tt> "; 
        echo "in the <tt>[users]</tt> section:</p>\n";

        if ( function_exists('sha1') ) {
            $fkt = 'sha1' ; 
        } else {
            $fkt = 'md5' ; 
        } ;
        $salt = dechex(mt_rand());
        $hash = $fkt . ':' . $salt . ':' . $fkt($salt . $password);

        echo "<pre>$u = &quot;$hash&quot;</pre>\n";
        echo "See <tt>help.txt</tt> for Help "; 
    }
}
?>
<p><input type="submit" value="Update"/></p>
</fieldset>
</form>
<hr/>



</body>
</html>
