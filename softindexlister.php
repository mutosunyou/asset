<?php
session_start();
require_once('master/prefix.php');

$sql='select softID from link where deviceID='.$_POST['did'];
$rst=selectData(DB_NAME,$sql);

$sql = 'select id from soft where isalive=1 ';
if($_POST['did']!=null){
  $sql.= 'and id in (';
  for($i=0;$i<count($rst);$i++){
    $sql.=$rst[$i]['softID'];
    if($i!=(count($rst)-1)){
      $sql.=',';
    }
  }
$sql.=') ';
}
if (isset($_POST['searchKey']) && strlen($_POST['searchKey']) > 0) {
  $sql .= ' and (name like "%'.$_POST['searchKey'].'%" or ver like "%'.$_POST['searchKey'].'%" or lot like "%'.$_POST['searchKey'].'%" or description like "%'.$_POST['searchKey'].'%" or license like "%'.$_POST['searchKey'].'%")';
}
if(isset($_POST['sortKey']) && strlen($_POST['sortKey']) > 0){
  $sql .= ' order by '.$_POST['sortKey'];
}
$sql .= ' '.$_POST['sortOrder'];
//var_dump($sql);
$cst = selectData(DB_NAME, $sql);
//var_dump($cst);

$body = '';
//本文========================================================
//有効なプロミス項目を並べて表示
$pname = array(
  //"id"=>"id".' style="text-align:left;width:30px;"',
  "名称"=>"name".' style="text-align:left;width:50px;"',
  "バージョン"=>"ver".' style="text-align:left;width:100px;"',
  "製造番号"=>"lot".' style="text-align:left;width:50px;"',
  "ライセンス"=>"license".' style="text-align:left;width:50px;"',
  "購入日"=>"buydate".' style="text-align:left;width:50px;"',
  "備考"=>"description".' style="text-align:left;width:50px;"'
);

//表
$body .= '<table class="table table-condensed table-striped table-bordered">';
foreach($pname as $key => $value){
  $body .= '<th class="sorter" name='.$value.'>'.$key.'</th>';
}
$body .= '<th style="text-align:left;width:50px;">編集</th>';
for($i=0;$i<count($cst);$i++){//指定されたuserIDのデータ全て
  $sql='select * from soft where id='.$cst[$i]['id'];
  $rst=selectData(DB_NAME,$sql);
  $body .='<tr>';
  //$body .='<td style="nowrap"><a href="editsoft.php?did='.$_POST['did'].'&sid='.$rst[0]['id'].'">'.$rst[0]['id'].'</a></td>';
  $body .='<td style="nowrap">'.$rst[0]['name'].'</td>';
  $body .='<td style="nowrap">'.$rst[0]['ver'].'</td>';
  $body .='<td style="nowrap">'.$rst[0]['lot'].'</td>';
  $body .='<td style="nowrap">'.$rst[0]['license'].'</td>';
  $body .='<td style="nowrap">';
  if($rst[0]['buydate']!=null){
    $body.=date('Y-m-d',strtotime($rst[0]['buydate']));
  }else{
    $body.=' ';
  }
  $body.='</td>';
  $body .='<td style="nowrap">'.$rst[0]['description'].'</td>';
  $body .='<td style="nowrap"><button class="btn btn-xs btn-warning soft" sid='.$rst[0]['id'].'>編集</button></td>';
  $body .='</tr>';
}
$body .= '</table>';
echo $body;
