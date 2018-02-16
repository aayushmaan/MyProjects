<?php

include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');

$showTimeline = False;
if(Login::isLoggedIn()){
    $userid = Login::isLoggedIn();
    $showTimeline = True;
}
else
{
    echo 'Not Logged In';
}

if(isset($_GET['postid'])){
            Post::likePost($userid,$_GET['postid']);  
        }


if(isset($_POST['comment'])){
            Comment::createComment($_POST['commentbody'],$_GET['postid'],$userid);  
        }



$followingposts = DB::query('SELECT posts.id,posts.body,posts.likes,users.username FROM users,posts,followers
WHERE posts.user_id = followers.user_id AND posts.user_id = users.id');

foreach($followingposts as $post){
    
    $comments = Comment::displayComments($post['id'],Login::isLoggedIn());
    echo $post['body']."~".$post['username']."<br/>";
    echo "<form action='index.php?postid=".$post['id']."' method='post'>";
                        
    if(!DB::query('SELECT post_id from post_likes WHERE user_id=:userid and post_id=:postid',array(':userid'=>$userid,':postid'=>$post['id']))){

                    echo "<input type='submit' name='like' value='Like'>";
                }
                else {
                
                    echo "<input type='submit' name='unlike' value='Unlike'>";
                }
                    echo "<span>".$post['likes']." likes</span>
                    </form>";
                    echo "<div style='margin-left:30px'>".$comments."</div>";
                    echo "<form action='index.php?postid=".$post['id']."' method='post' style='margin-left:30px'>
                    <textarea name='commentbody' rows='3' cols='50'></textarea>
                    <input type='submit' name='comment' value='Comment'>
                    </form>";
                    echo "
                    <hr/><br/>";
}
?>