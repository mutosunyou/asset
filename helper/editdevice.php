<?php
require_once('../master/prefix.php');


//ログイン処理======================================
$sql = "SELECT * FROM employee";
$rst = selectData('master',$sql);
if (isset($_SESSION["login_name"])){
  $sessionCounter = 0;
  for($i = 0; $i < count($rst); $i++) {
    if ($_SESSION["login_name"] == $rst[$i]["person_name"]){
      $sessionCounter = $sessionCounter + 1;
    }
  }
  if ($sessionCounter == 0){
    header("Location: index.php");
    exit;
  }
  $_SESSION['loginid']=userIDFromName($_SESSION["login_name"]);
}else{
  header("Location: ../../portal/index.php");
  exit;
}
$_SESSION['expires'] = time();
if ($_SESSION['expires'] < time() - 7) {
  session_regenerate_id(true);//sessionIDを生成しなおす
  $_SESSION['expires'] = time();
}

if($_GET['did']!=null){
  $sql='select * from device where id='.$_GET['did'];
  $rst_did=selectData(DB_NAME,$sql);
}

//ナビバー=========================================
$body='<nav class="navbar navbar-default navbar-fixed-top" role="navigation">';
$body.='<div class="container-fluid">';
$body.='<div class="navbar-header">';
$body.='<!-- 
  メニューボタン 
  data-toggle : ボタンを押したときにNavbarを開かせるために必要
  data-target : 複数navbarを作成する場合、ボタンとナビを紐づけるために必要
  -->
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-menu-1">
  <span class="sr-only">Toggle navigation</span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>';
$body.='<a class="navbar-brand" href="/php/menu" tabindex="-1"><img alt="Brand" src="../master/favicon.ico"></a>'; 
$body.='</div>';
$body.='<div class="collapse navbar-collapse" id="nav-menu-1">';

//左側
$body.='<ul class="nav navbar-nav">';
$body.='<li id="listrun" class="bankmenu"><a tabindex="-1">資産管理</a></li>';
$body.='<li id="list" class="active applymenu"><a href="../index.php" tabindex="-1">機器リスト</a></li>';
$body.='<li  class="applymenu"><a href="../softindex.php" tabindex="-1">ソフトリスト</a></li>';
$body.='<li  class="applymenu"><a href="#" tabindex="-1">　　　</a></li>';
$body.='<li  class="applymenu"><a href="#" tabindex="-1">　　　</a></li>';
$body.='</ul>';

//右側
$body.='<ul class="nav navbar-nav pull-right">';
$body.='<li><a href="../master/logout.php">ログアウト</a></li>';
$body.='<li><a tabindex="-1">'.$_SESSION['login_name'].'</a></li>';
$body.='</ul>';

$body.='</div>';
$body.='</div>';
$body.='</nav>';
//隙間調整=========================================
$body.='<div id="topspace" style="height:70px;"></div>';
//クラスと変数=====================================
$body.='<input id="did" class="hidden" value="'.$_GET['did'].'">';
//--------------------------------------------------
$body.='<div class="container-fluid">';
$body.='<div class="container">';
$body.='<h2>';
$body.='機器情報　';
if($_GET['did']==null){
  $body.='<追加>';
}else{
  $body.='<変更>';
}
$body.='</h2><hr />';
$body.='<div class="well" style="padding:25px 30px 25px 30px;">';
//---------------------------------------------------
$sql_cate='select * from category';
$rst_cate=selectData(DB_NAME,$sql_cate);
$body.='<div class="input-group input-group" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon1">種　　別</span>';
$body.='<select id="category" class="form-control">';
if($_GET['did']==null){
  $body.='<option selected>　</option>';
} 
for($i=0;$i<count($rst_cate);$i++){
  $body.='<option value="'.($i+1).'"';
  if(($i+1)==$rst_did[0]['category']){
    $body.='selected>';
  }else{
    $body.='>';
  }
  $body.=$rst_cate[$i]['name'].'</option>';
}
$body.='</select>';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon2">メーカー</span>';
$body.='<input type="text" id="maker" class="form-control" value="'.$rst_did[0]['maker'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon3">型　　番</span>';
$body.='<input type="text" id="type" class="form-control" value="'.$rst_did[0]['type'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon4">製造番号</span>';
$body.='<input type="text" id="lot" class="form-control" value="'.$rst_did[0]['lot'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon5">購入日　</span>';
$body.='<input type="text" id="buydate" class="datepicker form-control" value="'.$rst_did[0]['buydate'].'">';
$body.='</div>';
//--------------------
$sql_man='select * from employee';
$rst_man=selectData('master',$sql_man);

$body.='<div class="input-group input-group" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon6">所有者　</span>';
$body.='<select id="owner" class="form-control">';
if($_GET['did']==null || $rst_did[0]['owner']==0){
  $body.='<option selected>　</option>';
} 
for($i=0;$i<count($rst_man);$i++){
  $body.='<option value="'.$rst_man[$i]['id'].'"';
  if($rst_man[$i]['id']==$rst_did[0]['owner']){
    $body.='selected';
  }
  $body.='>'.$rst_man[$i]['person_name'].'</option>';
}
$body.='</select>';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon1">備　　考</span>';
$body.='<input type="text" id="desc" class="form-control" value="'.$rst_did[0]['description'].'">';
$body.='</div>';
//--------------------
$body.='</div>';
if($rst_did!=null){
  $body.='<button id="deletebtn" class="btn btn-danger btn pull-right">削除</button>';
  $body.='<button id="changebtn" class="btn btn-warning btn pull-right" disabled="disabled" style="margin:0 50px 0 0;">変更</button>';
}else{
  $body.='<button id="addbtn" class="btn btn-primary btn pull-right" disabled="disabled">追加</button>';
}
//---------------------------------------------------
$body.='</div>';//container
$body.='</div>';//container-fluid
//ヘッダー===========================================
$header ='<script type="text/javascript" src="editdevice.js"></script>';
$header.='<style type="text/css">';
$header.='<!--
  .input-group{
  margin:5px 10px 5px 0;
  }
  -->';
$header.='</style>';

//HTML作成===========================================
echo html('資産管理',$header, $body);
