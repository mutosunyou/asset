<?php
session_start();
require_once('master/prefix.php');

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
  header("Location: ../portal/index.php");
  exit;
}
$_SESSION['expires'] = time();
if ($_SESSION['expires'] < time() - 7) {
  session_regenerate_id(true);//sessionIDを生成しなおす
  $_SESSION['expires'] = time();
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
$body.='<a class="navbar-brand" href="/php/menu" tabindex="-1"><img alt="Brand" src="./master/favicon.ico"></a>'; 
$body.='</div>';
$body.='<div class="collapse navbar-collapse" id="nav-menu-1">';

//左側
$body.='<ul class="nav navbar-nav">';
$body.='<li id="listrun" class="bankmenu"><a tabindex="-1">資産管理</a></li>';
$body.='<li id="list" class="active applymenu"><a href="#" tabindex="-1">機器リスト</a></li>';
$body.='<li  class="applymenu"><a href="softindex.php" tabindex="-1">ソフトリスト</a></li>';
$body.='<li  class="applymenu"><a href="#" tabindex="-1">　　　</a></li>';
$body.='<li  class="applymenu"><a href="#" tabindex="-1">　　　</a></li>';
$body.='</ul>';

//右側
$body.='<ul class="nav navbar-nav pull-right">';
$body.='<li><a href="./master/logout.php">ログアウト</a></li>';
$body.='<li><a tabindex="-1">'.$_SESSION['login_name'].'</a></li>';
$body.='</ul>';

$body.='</div>';
$body.='</div>';
$body.='</nav>';

//隙間調整=========================================
$body.='<div id="topspace" style="height:70px;"></div>';

//クラスと変数=====================================
$body.='<input id="userID" class="hidden" value="'.$_SESSION['loginid'].'">';

//本文/////////////////////////////////////////////
//タイトル=========================================
$body.='<div class="container-fluid">';
$body.='<div class="container">';
$body.='<h2>';
$body.='機器リスト';
$body.='</h2><hr />';
$body .= '<div class="pull-right form-inline">';
$body .= '表示：<select class="form-control" id="ppi">';
$body .= '<option value="10">10</option>';
for ($i=1; $i < 11; $i++) {
  $body .= '<option value="'.($i * 20).'">'.($i * 20).'</option>';
}
$body .='</select>件　';
$body .='<input id="finderfld" class="form-control" type="text">';
$body .='<a id="finderbtn" class="btn btn-default" style="margin:0 10px 0 10px;">検索</a>';
$body .='<a class="btn btn-success" href="helper/editdevice.php">追加</a>';
$body .='</div>';
$body .='<div class="clearfix"></div>';

//一番上のエリア
$body.='<div id="devicelist"></div>';

$body.='<div id="ppp"></div>';//デバッグ用

$body.='</div>';//container
$body.='</div>';//container-fluid

//ヘッダー===========================================
$header ='<script type="text/javascript" src="index.js"></script>';
$header.='<style type="text/css">';
$header.='<!--
  .input-group{
  margin:5px 10px 5px 0;
  }
  -->';
$header.='</style>';

//HTML作成===========================================
echo html('資産管理',$header, $body);
