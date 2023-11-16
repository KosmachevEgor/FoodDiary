<?php

$connection = new mysqli("localhost","root","*****","food_diary");
$bdname = $_SESSION['username'];
$bdTable = "CREATE TABLE $bdname (
 MyData VARCHAR(100),
 Calori VARCHAR(10000)
)";
$_SESSION['tableName'] = $bdTable;
$connection->query($bdTable);