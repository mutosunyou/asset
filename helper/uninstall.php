<?php
require_once('../master/prefix.php');

$sql='update link set isalive=0 where softID='.$_POST['sid'].' and deviceID='.$_POST['did'];
deleteFrom(DB_NAME,$sql);
