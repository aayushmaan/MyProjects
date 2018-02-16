<?php

include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');

$username="";
$isFollowing = False;

if(Login::isLoggedIn()){
    echo 'Logged In';
}
else
{
    echo 'Not Logged In';
}

if(isset($_GET['username']))
{
    
    if(DB::query('SELECT username FROM users WHERE username=:username',array(':username'=>$_GET['username'])))
    {
        $username = DB::query('SELECT username FROM users WHERE username=:username',array(':username'=>$_GET['username']))[0]['username'];
        $userid=DB::query('SELECT id FROM users WHERE username=:username',array(':username'=>$_GET['username']))[0]['id'];
        $followerid=Login::isLoggedIn();
        
        echo $userid." ".$followerid;
        
        if(isset($_POST['follow'])){
            if($userid != $followerid){
                    echo "follow";
                if(!DB::query('SELECT follower_id from followers where follower_id=:followerid AND user_id=:userid',array('followerid'=>$followerid,':userid'=>$userid))){
                    echo " in";
                    DB::query('INSERT into followers(user_id,follower_id) VALUES(:userid,:followerid)',array(':userid'=>$userid,':followerid'=>$followerid));
                    } else {
                        echo 'Already following';
                    }
                    $isFollowing = True;
                    } 
        } 
        
        if(isset($_POST['unfollow'])){
            
            if($userid != $followerid){
                
                    if(DB::query('SELECT follower_id from followers where follower_id=:followerid AND user_id=:userid',array('followerid'=>$followerid,':userid'=>$userid))){
                        DB::query('DELETE from followers WHERE follower_id=:followerid AND user_id=:userid',array('followerid'=>$followerid,':userid'=>$userid));
                    } 

                    $isFollowing= False;
                 }
        }
        
        if(DB::query('SELECT follower_id from followers where user_id=:userid',array(':userid'=>$userid))){
               
            $isFollowing = True;
         }
        
        if(isset($_POST['postStatus'])){
            Post::createPost($_POST['postbody'],Login::isLoggedIn(),$userid);
        }
        
        if(isset($_GET['postid'])){
            Post::likePost($followerid,$_GET['postid']);
            
        }
        
        $posts = Post::displayPosts($username,$userid,$followerid);
    }
    else
    {
        die('USer not found!');
    }
}
?>

<h1><?php echo $username; ?>'s Profile</h1>
<form action="profile.php?username=<?php echo $username; ?>" method="post">
    <?php
    
    if($userid != $followerid)
    {
        if($isFollowing)
        {
            echo '<input type="submit" name="unfollow" value="unfollow">';
        } else {
            echo '<input type="submit" name="follow" value="follow">';
        }
    }
        ?>
</form>

<form action="profile.php?username=<?php echo $username; ?>" method="post">
    <textarea name="postbody" rows="5" cols="50"></textarea>
    <input type="submit" name="postStatus" value="postStatus">
</form>

<div class="posts">
    <?php echo $posts; ?>
</div>