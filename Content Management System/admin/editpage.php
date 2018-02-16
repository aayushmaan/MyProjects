<?php
require('../includes/config.php');

if(!isset($_GET['id']) || $_GET['id']== ''){
    header('Location:'.DIRADMIN);
}

if(isset($_POST['submit'])){
    $title = $_POST['pageTitle'];
    $content = $_POST['pageCont'];
    $pageID = $_POST['pageID'];
    
    $title = mysql_real_escape_string($title);
    $content = mysql_real_escape_string($content);
    
    mysql_query("UPDATE pages SET pageTitle='$title',pageCont='$pageCont' WHERE pageID='$pageID'");
    $_SESSION['success']='Page Updated';
    header('Location:'.DIRADMIN);
    exit();
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITETITLE;?></title>
<link href="<?php echo DIR;?>style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">

<!-- NAV -->
<div id="navigation">
<ul class="menu">
<li><a href="<?php echo DIRADMIN;?>">Admin</a></li>
<li><a href="<?php echo DIRADMIN;?>?logout">Logout</a></li>
<li><a href="<?php echo DIR;?>" target="_blank">View Website</a></li>
</ul>
</div>
<!-- END NAV -->

<div id="content">
    <h1>Edit Page</h1>
    
<?php
    $id = $_GET['id'];
    $id = mysql_real_escape_string($id);
    $q = mysql_query("SELECT * FROM pages WHERE pageID='$id'");
    $row = mysql_fetch_object($q);
?>
    
    <form action="" method="post">
        <input type="hidden" name="pageID" value="<?php echo $row->pageID;?>"/>
        <p>
            Title:<br/> <input name="pageTitle" type="text" value="<?php echo $row->pageTitle;?>" size="103"/>
        </p>
        <p>
            Content:<br/> <textarea name="pageCont" row="20" cols="100" value="<?php echo $row->pageCont;?>"></textarea>
        </p>
        <p>
            <input name="submit" type="submit" value="Submit" class="button"/>
        </p>
    </form>
    </div>
    <div id="footer">    
        <div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div>
</div>

</body>
</html>