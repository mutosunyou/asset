<?php
require_once('../master/prefix.php');

if($_POST["maker"]!=null){
  $maker='"'.$_POST["maker"].'"';
}else{
  $maker="null";
}
if($_POST["type"]!=null){
  $type='"'.$_POST["type"].'"';
}else{
  $type="null";
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


$sql='insert into device (category,maker,type,lot,buydate,owner,description,isalive) VALUES ('.$_POST["category"].','.$maker.','.$type.','.$lot.','.$buydate.','.$_POST["owner"].','.$desc.',1)';
deleteFrom(DB_NAME,$sql);
