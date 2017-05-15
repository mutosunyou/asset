<?php
session_start();
require_once('../master/prefix.php');

$sql = 'select deviceID from link where isalive=1 and softID='.$_POST['sid'];
$cst = selectData(DB_NAME, $sql);
//var_dump($sql);
$body = '';
//本文========================================================
//検索

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
$body.='<th name="device" style="text-align:left;width:50px;">機器情報</th>';
$sql='select * from category';
$rst_cate=selectData(DB_NAME,$sql);
for($i=0;$i<count($cst);$i++){//指定されたuserIDのデータ全て
  $sql='select * from device where id='.$cst[$i]['deviceID'];
  $rst=selectData(DB_NAME,$sql);
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
  $body .='<td style="nowrap"><button class="btn btn-default btn-xs dev" devid='.$rst[0]['id'].'>機器情報</button></td>';
  $body .='</tr>';
}
$body .= '</table>';
echo $body;
