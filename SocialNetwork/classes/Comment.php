<?php

    class Comment
    {
        public static function createComment($commentBody,$postId,$userId){
            
            if(!DB::query('SELECT id FROM posts WHERE id=:postid',array(':postid'=>$postId))){
                die('Invalid post ID!');
            } else {
                DB::query('INSERT INTO comments(comment,commented_at,user_id,post_id,likes) VALUES(:commentbody,NOW(),:userid,:postid,0)',array(':commentbody'=>$commentBody,':userid'=>$userId,':postid'=>$postId));
            }
        }
        
        public static function likePost($likerId,$commentId){
                if(!DB::query('SELECT user_id from comment_likes WHERE user_id=:userid and comment_id=:commentid',array(':userid'=>$likerId,':commentid'=>$commentId)))
               {
                    DB::query('UPDATE comments SET likes=likes+1 WHERE id=:commentid',array(':commentid'=>$commentid));
                    DB::query('INSERT INTO comment_likes(user_id,comment_id) VALUES(:userid,:commentid)',array(':userid'=>$likerId,':commentid'=>$commentid));
               }
               else {
                    DB::query('UPDATE comments SET likes=likes-1 WHERE id=:commentid',array(':commentid'=>$commentid));
                    DB::query('DELETE from comment_likes user_id=:userid and comment_id=:commentid',array(':userid'=>$likerId,':commentid'=>$commentid));
               }
        }
        
        public static function displayComments($postId,$likerId){
            $dbcomments = DB::query('SELECT comments.likes,comments.post_id,comments.comment,users.username,comments.id from comments,users WHERE comments.post_id=:postid AND comments.user_id = users.id',array(':postid'=>$postId));
            $comments = "";    
            foreach($dbcomments as $comm)
            {
                //echo $comm['comment']."~".$comm['username']."<hr/>";
                if(!DB::query('SELECT comment_id from comment_likes WHERE user_id=:userid and comment_id=:commentid', array(':userid'=>$likerId,':commentid'=>$comm['id']))){

                    $comments .= htmlspecialchars($comm['comment'])."~".$comm['username']."
                    <form action='index.php?&postid=$postId' method='post'>
                    <input type='submit' name='like' value='Like'>
                    <span>".$comm['likes']." likes</span>
                    </form>
                    <br/>";
                }
                else {
                    $comments .= htmlspecialchars($comm['comment'])."
                    <form action='index.php?&postid=$postId' method='post'>
                    <input type='submit' name='unlike' value='Unlike'>
                    <span>".$comm['likes']." likes</span>
                    </form>
                    <br/>";
                }
            }
            return $comments;
        }
    }
?>