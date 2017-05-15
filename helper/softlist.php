<?php
session_start();
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
$body.='<a class="navbar-brand" href="../php/menu" tabindex="-1"><img alt="Brand" src="../master/favicon.ico"></a>'; 
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

//本文/////////////////////////////////////////////
//タイトル=========================================
$body.='<div class="container-fluid">';
$body.='<div class="container">';

//==================================
$body.='<h3>機器情報</h3>';
$sql='select * from device where id='.$_GET['did'];
$rst=selectData(DB_NAME,$sql);

$pname = array(
  "種別"=>"name".' style="text-align:left;width:50px;"',
  "メーカー"=>"maker".' style="text-align:left;width:100px;"',
  "製造番号"=>"lot".' style="text-align:left;width:50px;"',
  "型番"=>"type".' style="text-align:left;width:50px;"',
  "購入日"=>"buydate".' style="text-align:left;width:50px;"',
  "ユーザー"=>"owner".' style="text-align:left;width:50px;"',
  "備考"=>"description".' style="text-align:left;width:50px;"',
);
$sql='select * from category';
$rst_cate=selectData(DB_NAME,$sql);
//表
$body .= '<table class="table table-condensed table-striped table-bordered">';
foreach($pname as $key => $value){
  $body .= '<th class="sorter" name='.$value.'>'.$key.'</th>';
}
$body .='<tr>';
$body .='<td style="nowrap">'.$rst_cate[$rst[0]['category']-1]['name'].'</td>';
$body .='<td style="nowrap">'.$rst[0]['maker'].'</td>';
$body .='<td style="nowrap">'.$rst[0]['lot'].'</td>';
$body .='<td style="nowrap">'.$rst[0]['type'].'</td>';
$body .='<td style="nowrap">';
if($rst[0]['buydate']!=null){
  $body.=date('Y-m-d',strtotime($rst[0]['buydate']));
}else{
  $body.=' ';
}
$body.='</td>';
$body .='<td style="nowrap">'.nameFromUserID($rst[0]['owner']).'</td>';
$body .='<td style="nowrap">'.$rst[0]['description'].'</td>';
$body .='</tr>';
$body .='</table>';
//==================================
$body.='<div class="clearfix"></div>';
$body.='<hr>';
//==================================
$body.='<h3>インストール済みソフトウェア</h3>';
$body .= '<div class="pull-right form-inline">';

$body .='<input id="finderfld" class="form-control" type="text">';
$body .='<a id="finderbtn" class="btn btn-default" style="margin:0 10px 0 10px;">検索</a>';
$body .='<a class="btn btn-success" href="installsoft.php?did='.$_GET['did'].'">追加</a>';
$body .='</div>';
$body .='<div class="clearfix"></div><br>';
//===ソフトリスト
$body .='<div id="softlist"></div>';
//==================================

$body.='</div>';//container
$body.='</div>';//container-fluid

//ヘッダー===========================================
$header ='<script type="text/javascript" src="soft.js"></script>';
$header.='<style type="text/css">';
$header.='<!--
  .input-group{
  margin:5px 10px 5px 0;
  }
  -->';
$header.='</style>';

//HTML作成===========================================
echo html('資産管理',$header, $body);
