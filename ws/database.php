<?php

$dbhost='localhost';
$db='bebal';
$dbuser='root';
$dbpass='Mexico@_1966';


############
$rows_for_page=5;

$conexionMG = mysqli_connect($dbhost, $dbuser,$dbpass, $db);
##if (mysqli_connect_errno()) {
##echo "Failed to connect to MySQL: " . mysqli_connect_error();
##exit();
##}




$conexionDB = new PDO("mysql:host=localhost;dbname=bebal", $dbuser,$dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

if ($mysqli -> connect_errno) {
die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno()
. ") " . $mysqli -> mysqli_connect_error());
}


$conexionDBsaveh = new PDO("mysql:host=localhost;dbname=saveh", $dbuser,$dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

if ($mysqli -> connect_errno) {
die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno()
. ") " . $mysqli -> mysqli_connect_error());
}
?>
