<?php
require_once('../master/prefix.php');
if($_POST["name"]!=null){
  $name='"'.$_POST["name"].'"';
}else{
  $name="null";
}
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

$sql='insert into soft (name,ver,lot,license,buydate,description,isalive) VALUES ('.$name.','.$ver.','.$lot.','.$license.','.$buydate.','.$desc.',1)';
$sid=insertAI(DB_NAME,$sql);



