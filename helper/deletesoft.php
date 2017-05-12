<?php
require_once('../master/prefix.php');

$sql='update soft set isalive=0 where id='.$_POST['sid'];
deleteFrom(DB_NAME,$sql);
