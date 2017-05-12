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


$sql='update device set category='.$_POST["category"].',maker='.$maker.',type='.$type.',lot='.$lot.',buydate='.$buydate.',owner='.$_POST["owner"].',description='.$desc.' where id='.$_POST['did'];
deleteFrom(DB_NAME,$sql);
