<?php
ob_start();
session_start();

//db properties
define('DBHOST','host');
define('DBUSER','database username');
define('DBPASS','password');
define('DBNAME','database name');

//make connection
$conn = @mysql_connect(DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db(DBNAME);
if(!$conn){
    die("Sorry! Can't connect to database");
}

define('DIR','http://www.domain.com/');

define('DIRADMIN','http://www.domain.com/admin/');

define('SITETITLE','Simple CMS');

define('included',1);

include('functions.php');
?>