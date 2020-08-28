<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'ljm';

$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

$myPDO = new PDO($dsn, $username, $password);
$myPDO->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
$myPDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

?>