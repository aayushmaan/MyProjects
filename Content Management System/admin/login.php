<?php

require('../includes/config.php');
if(logged_in()){ header('Location: '.DIRADMIN);}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo SITETITLE;?></title>
    </head>
    <body>
        <div class="lwidth">
            <div class="page-wrap">
                <div class="content">
                    <?php
                    if($_POST['submit']){
                        login($_POST['username'], $_POST['password']);
                    }
                    ?>
                    
                    <div id="login">
                        <p>
                            <?php echo messages();?>
                        </p>
                        <form method="post" action="">
                            <p>
                                <label>Username<input type="text" name="username"/></label>
                            </p>
                            <p>
                                <label>Password<input type="password" name="password"/></label>
                            </p>
                            <p>
                                <br/><input type="submit" name="submit" value="login" class="button"/>
                        </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer">
                &copy; <?php echo SITETITLE.' '.date('Y');?>
            </div>
        </div>
    </body>
</html>