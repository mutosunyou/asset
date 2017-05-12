<?php
require_once('../master/prefix.php');

//ローカルホストのみ
$_SESSION["login_name"]="武藤　一徳";

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

if($_GET['sid']!=null){
  $sql='select * from soft where id='.$_GET['sid'];
  $rst_sid=selectData(DB_NAME,$sql);
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
$body.='<li id="list" class="applymenu"><a href="../index.php" tabindex="-1">機器リスト</a></li>';
$body.='<li  class="active applymenu"><a href="../softindex.php" tabindex="-1">ソフトリスト</a></li>';
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
$body.='<input id="sid" class="hidden" value="'.$_GET['sid'].'">';

//--------------------------------------------------
$body.='<div class="container-fluid">';
$body.='<div class="container">';
$body.='<h2>';
$body.='ソフトウェア情報　';
if($_GET['sid']==null){
  $body.='<追加>';
}else{
  $body.='<変更>';
}
$body.='</h2><hr />';
$body.='<div class="well" style="padding:25px 30px 25px 30px;">';
//---------------------------------------------------

$body.='<div class="input-group input-group-lg" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon2">　名　称　</span>';
$body.='<input type="text" id="name" class="form-control" value="'.$rst_sid[0]['name'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group-lg" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon2">バージョン</span>';
$body.='<input type="text" id="ver" class="form-control" value="'.$rst_sid[0]['ver'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group-lg" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon4">製造番号　</span>';
$body.='<input type="text" id="lot" class="form-control" value="'.$rst_sid[0]['lot'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group-lg" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon3">ライセンス</span>';
$body.='<input type="text" id="license" class="form-control" value="'.$rst_sid[0]['license'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group-lg" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon5">購　入　日</span>';
$body.='<input type="text" id="buydate" class="datepicker form-control" value="'.$rst_sid[0]['buydate'].'">';
$body.='</div>';
//--------------------
$body.='<div class="input-group input-group-lg" style="margin:0 0 10px 0;">';
$body.='<span class="input-group-addon" id="sizing-addon1">　備　考　</span>';
$body.='<input type="text" id="desc" class="form-control" value="'.$rst_sid[0]['description'].'">';
$body.='</div>';
//--------------------
$body.='</div>';
if($rst_sid!=null){
  $body.='<button id="deletebtn" class="btn btn-danger btn-lg pull-right">削除</button>';
  $body.='<button id="changebtn" class="btn btn-warning btn-lg pull-right" disabled="disabled" style="margin:0 50px 0 0;">変更</button>';
}else{
  $body.='<button id="addbtn" class="btn btn-primary btn-lg pull-right" disabled="disabled">追加</button>';
}

//---------------------------------------------------
$body.='</div>';//container
$body.='</div>';//container-fluid
//ヘッダー===========================================
$header ='<script type="text/javascript" src="editsoft.js"></script>';
$header.='<style type="text/css">';
$header.='<!--
  .input-group{
  margin:5px 10px 5px 0;
  }
  -->';
$header.='</style>';

//HTML作成===========================================
echo html('資産管理',$header, $body);
