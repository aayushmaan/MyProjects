<?php
include('classes\DB.php');

if(isset($_POST['login'])) {
    $username=$_POST['username'];
    $password=$_POST['password'];
    
    if(DB::query('SELECT username FROM users WHERE username=:username',array(':username'=>$username))){
        if(password_verify($password,DB::query('SELECT password FROM users WHERE username=:username',array(':username'=>$username))[0]['password'])){
            echo 'Logged in';
            
            $cstrong= True;
            $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
            echo $token;
            
            $user_id= DB::query('SELECT id from users WHERE username=:username',array(':username'=>$username))[0]['id'];
            DB::query('INSERT into login_tokens(token,user_id) VALUES(:token,:user_id)',array(':token'=>sha1($token),':user_id'=>$user_id));
            
            setcookie("SNID",$token,time()+60*60*24*7,'/',NULL,NULL,TRUE); //2nd last is true for https and for last javascript cannot access so protect from attacks
            
            setcookie("SNID_",'1',time()+60*60*24*3,'/',NULL,NULL,TRUE);
        }else{
            echo 'Wrong password';
        }
    }
    else{
        echo 'User not registered';
    }
}
?>
<h1>Login</h1>

<form action="login.php" method="post">
    <input type="text" name="username" value="" placeholder="USername..."><p/>
    <input type="password" name="password" value="" placeholder="Password..."><p/>
    <input type="submit" name="login" value="Login">
</form>