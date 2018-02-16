<?php

    class Post
    {
        public static function createPost($postbody,$loggedInUserId,$profileUserId){
            
            if($loggedInUserId == $profileUserId){
            DB::query('INSERT INTO posts(body,posted_at,user_id,likes) VALUES(:postbody,NOW(),:userid,0)',array(':postbody'=>$postbody,':userid'=>$loggedInUserId));
            } else {
                die('Incorrect user!');
            }
        }
        
        public static function likePost($likerId,$postid){
                if(!DB::query('SELECT user_id from post_likes WHERE user_id=:userid and post_id=:postid',array(':userid'=>$likerId,':postid'=>$postid)))
               {
                    DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid',array(':postid'=>$postid));
                    DB::query('INSERT INTO post_likes(user_id,post_id) VALUES(:userid,:postid)',array(':userid'=>$likerId,':postid'=>$postid));
               }
               else {
                    DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid',array(':postid'=>$postid));
                    DB::query('DELETE from post_likes WHERE user_id=:userid and post_id=:postid',array(':userid'=>$likerId,':postid'=>$postid));
               }
        }
        
        public static function displayPosts($username,$profileUserId,$likerId){
            $dbposts = DB::query('SELECT * from posts WHERE user_id=:userid',array(':userid'=>$profileUserId));
            $posts = "";    
            foreach($dbposts as $p)
            {
                if(!DB::query('SELECT post_id from post_likes WHERE user_id=:userid and post_id=:postid',array(':userid'=>$likerId,':postid'=>$p['id']))){

                    $posts .= htmlspecialchars($p['body'])."
                    <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                    <input type='submit' name='like' value='Like'>
                    <span>".$p['likes']." likes</span>
                    </form>
                    <br/>";
                }
                else {
                    $posts .= htmlspecialchars($p['body'])."
                    <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                    <input type='submit' name='unlike' value='Unlike'>
                    <span>".$p['likes']." likes</span>
                    </form>
                    <br/>";
                }
            }
            return $posts;
        }
    }
?>