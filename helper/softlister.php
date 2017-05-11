<?php
session_start();
require_once('../master/prefix.php');

echo "rarara";
$sql='select * from link where deviceID='.$_POST['did'];
$rst=selectData(DB_NAME,$sql);
$sql = 'select id from soft where id in (';
for($i=0;$i<count($rst);$i++){
  $sql.=$rst[$i]['id'];
  if($i!=(count($rst)-1)){
    $sql.=',';
  }
}
$sql.=') and isalive=1 ';
var_dump($sql);
if (isset($_POST['searchKey']) && strlen($_POST['searchKey']) > 0) {
  $sql .= ' and (name like "%'.$_POST['searchKey'].'%" or ver like "%'.$_POST['searchKey'].'%" or lot like "%'.$_POST['searchKey'].'%" or description like "%'.$_POST['searchKey'].'%")';
}
if(isset($_POST['sortKey']) && strlen($_POST['sortKey']) > 0){
  $sql .= ' order by '.$_POST['sortKey'];
}
$sql .= ' '.$_POST['sortOrder'];
$cst = selectData(DB_NAME, $sql);
//項目数を取得
$cr = count($cst);


$body = '';
//本文========================================================

//有効なプロミス項目を並べて表示
$pname = array(
  "id"=>"id".' style="text-align:left;width:30px;"',
  "種別"=>"name".' style="text-align:left;width:50px;"',
  "メーカー"=>"maker".' style="text-align:left;width:100px;"',
  "製造番号"=>"lot".' style="text-align:left;width:50px;"',
  "型番"=>"type".' style="text-align:left;width:50px;"',
  "購入日"=>"buydate".' style="text-align:left;width:50px;"',
  "ユーザー"=>"owner".' style="text-align:left;width:50px;"',
  "備考"=>"description".' style="text-align:left;width:50px;"',
  "ソフト一覧"=>"soft".' style="text-align:left;width:50px;"'
);

//表
$body .= '<table class="table table-condensed table-striped table-bordered">';
foreach($pname as $key => $value){
  $body .= '<th class="sorter" name='.$value.'>'.$key.'</th>';
}
$sql='select * from category';
$rst_cate=selectData(DB_NAME,$sql);
for($i=0;$i<count($cst);$i++){//指定されたuserIDのデータ全て
  $sql='select * from device where id='.$cst[$i]['id'];
  $rst=selectData(DB_NAME,$sql);
  $body .='<tr>';
  $body .='<td style="nowrap"><a href="helper/editdevice.php?did='.$rst[0]['id'].'">'.$rst[0]['id'].'</a></td>';
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
}
$body .= '</table>';
echo $body;
