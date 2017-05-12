<?php
require_once('../master/prefix.php');

$sql='insert into link (deviceID,softID) values ('.$_POST["did"].','.$_POST["sid"].')';
deleteFrom(DB_NAME,$sql);
