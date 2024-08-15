<?php 

$sql_db_host = "localhost";
$sql_db_user = "root";
$sql_db_pass = "";
$sql_db_name = "schedule";

$table_admin = "admin";

$table_cat = "categories";

$table_user = "users";

$table_sch = "schedules";

define("sql_db_host", $sql_db_host);
define("sql_db_user", $sql_db_user);
define("sql_db_pass", $sql_db_pass);
define("sql_db_name", $sql_db_name);


session_start();

$conn = new mysqli(sql_db_host, sql_db_user, sql_db_pass, sql_db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$GLOBALS['name'] = "Schedule";

?>