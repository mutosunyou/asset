<?php
session_start();
require_once('../master/prefix.php');

$sql = 'select id from device where isalive=1 ';
if (isset($_POST['searchKey']) && strlen($_POST['searchKey']) > 0) {
  $sql .= ' and (description like "%'.$_POST['searchKey'].'%" or type like "%'.$_POST['searchKey'].'%" or maker like "%'.$_POST['searchKey'].'%" or lot like "%'.$_POST['searchKey'].'%")';
}
if(isset($_POST['sortKey']) && strlen($_POST['sortKey']) > 0){
  $sql .= ' order by '.$_POST['sortKey'];
}
$sql .= ' '.$_POST['sortOrder'];
$cst = selectData(DB_NAME, $sql);
//項目数を取得
$cr = count($cst);
if ($_POST['itemsPerPage'] != 0) {
  $sql .= ' limit '.$_POST['itemsPerPage'].' offset '.(($_POST['page'] - 1) * $_POST['itemsPerPage']);
}
$cst = selectData(DB_NAME, $sql);

$body = '';
//本文========================================================
//検索
$body .= '<div class="pull-left form-inline" style="float:right;margin:0 0 10px 0;">';
$countofpage = ceil($cr/intval($_POST['itemsPerPage']));

//ページ番号
$body .='<nav class="form-inline pull-left" style="margin:10px 0 0 0;">';
$body .='<ul class="pagination pagination-sm" style="margin:0 0 0 0;">';
for ($i=1; $i <= $countofpage; $i++){
  $body .= '<li';
  if ($i == $_POST['page']){
    $body .= ' class="active"';
  }
  $body .= '><a class="pagebtn" name="'.$i.'">'.$i.'</a></li>';
}
$body .= '</ul>';
$body .= '</nav>';
$body .= '</div>';

//有効なプロミス項目を並べて表示
$pname = array(
  "種別"=>"category".' style="text-align:left;width:50px;"',
  "メーカー"=>"maker".' style="text-align:left;width:100px;"',
  "製造番号"=>"lot".' style="text-align:left;width:50px;"',
  "型番"=>"type".' style="text-align:left;width:50px;"',
  "購入日"=>"buydate".' style="text-align:left;width:50px;"',
  "ユーザー"=>"owner".' style="text-align:left;width:50px;"',
  "備考"=>"description".' style="text-align:left;width:50px;"');

//表
$body .= '<table class="table table-condensed table-striped table-bordered">';
foreach($pname as $key => $value){
  $body .= '<th class="sorter" name='.$value.'>'.$key.'</th>';
}
$body .= '<th style="text-align:left;width:50px;">編集</th>';  
$body .= '<th style="text-align:left;width:50px;">機器詳細</th>';
$sql='select * from category';
$rst_cate=selectData(DB_NAME,$sql);
for($i=0;$i<count($cst);$i++){//指定されたuserIDのデータ全て
  $sql='select * from device where id='.$cst[$i]['id'];
  $rst=selectData(DB_NAME,$sql);
  $body .='<tr>';
//  $body .='<td style="nowrap"><a href="helper/editdevice.php?did='.$rst[0]['id'].'">'.$rst[0]['id'].'</a></td>';
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
  $body .='<td style="nowrap"><button sid="'.$rst[0]['id'].'" class="edit btn-xs btn-warning">編集</button></td>';
  $body .='<td style="nowrap"><button sid="'.$rst[0]['id'].'" class="soft btn-xs btn-default">機器詳細</button></td>';
  $body .='</tr>';
}
$body .= '</table>';
echo $body;
