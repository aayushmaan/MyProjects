<?php
require('../includes/config.php');

login_required();

if(isset($_GET['logout'])){
	logout();
}

if(isset($_GET['delpage'])){
    
    $delpage = $_GET['delpage'];
    
    $delpage = mysql_real_escape_string($delpage);
    
    mysql_query("DELETE FROM pages WHERE pageID='$delpage'") or die(mysql_error());
    $_SESSION['success']='Page Deleted';
    header('Location:'.DIRADMIN);
    exit();
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITETITLE;?></title>
<link href="<?php echo DIR;?>style/style.css" rel="stylesheet" type="text/css" />
    <script language="Javascript" type="text/javascript">
        function delpage(id, title)
        {
            if(confirm("Are you sure you want to delete '"+ title + "'"));
            {
                window.location.href='<?php echo DIRADMIN;?>?delpage=' + id;
            }
        }
    </script>
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

<?php 
    messages();
?>
    <h1>Manage Pages</h1>
    
    <table>
        <tr>
            <th>
                <strong>Title</strong>
            </th>
            <th>
                <strong>Actions</strong>
            </th>
        </tr>
        
<?php
        $sql = mysql_query("SELECT * from pages ORDER BY pageID");
        while($row = mysql_fetch_object($sql))
        {
            echo "<tr>";
                echo "<td>$row->pageTitle</td>";
                if($row->pageID==1){
                    echo "<td><a href=\"".DIRADMIN."editpage.php?id=$row->pageID\">Edit</a></td>";
                } else {
                    echo "<td><a href=\"".DIRADMIN."editpage.php?id=$row->pageID\">Edit</a> | <a href=\"javascript:delpage('$row->pageID','$row->pageTitle');\">DELETE</a></td>";
                }
            echo "</tr>";
        }
?>
    </table>
    
    <p><a href="<?php echo DIRADMIN;?>addpage.php" class="button">Add Page</a></p>
</div>
    </div>
    <div id="footer">    
        <div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div>
</div>

</body>
</html>