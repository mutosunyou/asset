<?php
require_once('../master/prefix.php');

if($_POST["ver"]!=null){
  $ver='"'.$_POST["ver"].'"';
}else{
  $ver="null";
}
if($_POST["license"]!=null){
  $license='"'.$_POST["license"].'"';
}else{
  $license="null";
}
if($_POST["lot"]!=null){
  $lot='"'.$_POST["lot"].'"';
}else{
  $lot="null";
}
if($_POST["buydate"]!=null){
  $buydate='"'.$_POST["buydate"].'"';
}else{
  $buydate="null";
}
if($_POST["desc"]!=null){
  $desc='"'.$_POST["desc"].'"';
}else{
  $desc="null";
}


$sql='update soft set name="'.$_POST["name"].'",ver='.$ver.',license='.$license.',lot='.$lot.',buydate='.$buydate.',description='.$desc.' where id='.$_POST['sid'];
deleteFrom(DB_NAME,$sql);
