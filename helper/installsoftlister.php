<?php
session_start();
require_once('../master/prefix.php');

//クラスと変数=====================================
$sql='select softID from link where isalive=1 and deviceID='.$_POST['did'];
$rst_soft=selectData(DB_NAME,$sql);
//===ソフトリスト
$sql = 'select * from soft where ';
if(count($rst_soft)>0){
  $sql.=' id not in (';
  for($i=0;$i<count($rst_soft);$i++){
    $sql.=$rst_soft[$i]['softID'];
    if($i!=(count($rst_soft)-1)){
      $sql.=',';
    }
  }
  $sql.=') and ';
}
$sql.='isalive=1 ';
if (isset($_POST['searchKey']) && strlen($_POST['searchKey']) > 0) {
  $sql .= ' and (description like "%'.$_POST['searchKey'].'%" or ver like "%'.$_POST['searchKey'].'%" or name like "%'.$_POST['searchKey'].'%" or lot like "%'.$_POST['searchKey'].'%")';
}
if(isset($_POST['sortKey']) && strlen($_POST['sortKey']) > 0){
  $sql .= ' order by '.$_POST['sortKey'];
}
$sql .= ' '.$_POST['sortOrder'];
$rst=selectData(DB_NAME,$sql);
//==================================
$pname = array(
  "名称"=>"name".' style="text-align:left;width:50px;"',
  "バージョン"=>"ver".' style="text-align:left;width:100px;"',
  "製造番号"=>"lot".' style="text-align:left;width:50px;"',
  "ライセンス"=>"license".' style="text-align:left;width:50px;"',
  "購入日"=>"buydate".' style="text-align:left;width:50px;"',
  "備考"=>"description".' style="text-align:left;width:50px;"',
  "追加"=>"add".' style="text-align:left;width:30px;"'
);
//表
$body .= '<table class="table table-condensed table-striped table-bordered">';
foreach($pname as $key => $value){
  $body .= '<th class="sorter" name='.$value.'>'.$key.'</th>';
}
for($i=0;$i<count($rst);$i++){
  $sql='select * from link where isalive=1 and softID='.$rst[$i]['id'];
  $rst_li=selectData(DB_NAME,$sql);
if(count($rst_li)<$rst[$i]['license']){
  $body .='<tr>';
  $body .='<td style="nowrap">'.$rst[$i]['name'].'</td>';
  $body .='<td style="nowrap">'.$rst[$i]['ver'].'</td>';
  $body .='<td style="nowrap">'.$rst[$i]['lot'].'</td>';
  $body .='<td style="nowrap">'.count($rst_li).'／'.$rst[$i]['license'].'</td>';

  $body .='<td style="nowrap">';
  if($rst[$i]['buydate']!=null){
    $body.=date('Y-m-d',strtotime($rst[$i]['buydate']));
  }else{
    $body.=' ';
  }
  $body.='</td>';
  $body .='<td style="nowrap">'.$rst[$i]['description'].'</td>';
  $body .='<td style="nowrap"><button class="btn btn-success btn-xs addsoft" sid='.$rst[$i]['id'].'>追加</a></td>';
  $body .='</tr>';
}
}
$body .= '</table>';
echo $body;

