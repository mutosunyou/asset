//localstorageを初期化
//検索キーワード
localStorage.assetType = "run";

//検索キーワード
localStorage.assetSearchKey = '';

//並べ替えのキー値
localStorage.assetSortKey = "id";
//並べ替えの昇順降順
if (!localStorage.assetSortOrder) {
  localStorage.assetSortOrder = 'asc';
}

if (!localStorage.assetppi) {
  localStorage.assetppi = 20;
}

if (!localStorage.assetpage) {
  localStorage.assetpage = 1;
}


//初期動作====================================================
$(function() {
  var userID = $('#userID').val();
  $('#finderfld').val(localStorage.assetSearchKey);
  $('#ppi').val(localStorage.assetppi);
  $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});//カレンダーから日付を選ぶ

  reloadTable();

  //ボタン======================================================
  $('#devicelist').on('click', '.sorter', function (ev){
    localStorage.assetpage = 1;
    if (localStorage.assetSortKey == $(ev.target).attr('name')) {
      if (localStorage.assetSortOrder == 'asc') {
        localStorage.assetSortOrder = 'desc';
      }else{
        localStorage.assetSortOrder = 'asc';
      }
    }else{
      localStorage.assetSortOrder = 'asc';
    }
    localStorage.assetSortKey = $(ev.target).attr('name');
    reloadTable();
  });


  $('#ppi').change( function (){
    localStorage.assetppi = $('#ppi').val();
    reloadTable();
  });
   $('#devicelist').on('click', '.pagebtn', function (ev){
    localStorage.assetpage = $(ev.target).attr('name');
    reloadTable();
  });
  //検索ボタン押された
  $('#finderbtn').click( function (){
    localStorage.assetSearchKey = $('#finderfld').val();
    localStorage.assetpage = 1;
  $('#ppi').change( function (){
    localStorage.assetppi = $('#ppi').val();
    loadTable();
  });
    reloadTable();
  });
  //検索フィールドでエンター押された
  $('#finderfld').keypress( function (e) {
    if ( e.which == 13 ) {
      localStorage.assetSearchKey = $('#finderfld').val();
      localStorage.assetpage = 1;
      reloadTable();
      console.log(localStorage.assetSearchKey);
      return false;
    }
  });

//関数////////////////////////////////////////////////////////
//アンケートを表示する。
function reloadTable(){
  JSON = $.toJSON(qarray);
  $.post(
    "helper/devicelist.php",
    {
        "page":localStorage.assetpage,
        "itemsPerPage": $('#ppi').val(),
        "sortKey": localStorage.assetSortKey,
        "sortOrder": localStorage.assetSortOrder,
        "searchKey": localStorage.assetSearchKey,
        "type":localStorage.assetType
    },
    function(data){
      $('#devicelist').html(data);
    }
  );
}

