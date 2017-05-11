<?php
require_once('../master/prefix.php');

$sql='update device set isalive=0 where id='.$_POST['did'];
deleteFrom(DB_NAME,$sql);
