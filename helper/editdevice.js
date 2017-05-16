//初期動作====================================================
$(function() {
  var checkflg=0;
  pcate=$('#category').val();
  pmaker=$('#maker').val();
  ptype=$('#type').val();
  plot=$('#lot').val();
  pbuydate=$('#buydate').val();
  powner=$('#owner').val();
  pdesc=$('#desc').val();

  $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});//カレンダーから日付を選ぶ

  $('*').change(function(){
    if($('#category').val()!=pcate || $('#maker').val()!=pmaker || $('#type').val()!=ptype || $('#lot').val()!=plot || $('#buydate').val()!=pbuydate || $('#owner').val()!=powner || $('#desc').val()!=pdesc ){
      $('#changebtn').removeAttr('disabled');
    }else{
      $('#changebtn').attr('disabled', 'disabled');//disabled属性を付与する
    }
    if($('#category').val().length>0 && $('#owner').val().length>0 ){
      $('#addbtn').removeAttr('disabled');
    }else{
      $('#addbtn').attr('disabled', 'disabled');//disabled属性を付与する
    }
  });

  //ボタン======================================================
  //検索ボタン押された
  $('#changebtn').click( function (){
    reset();
    alertify.confirm("この機器情報を変更しますか？",function(e){
      if(e){
        change();
      }
    });
  });
  $('#addbtn').click( function (){
    add();
  }); 
  $('#deletebtn').click( function (){
    reset();
    alertify.confirm("この機器を消去しますか？（DB上では情報は閲覧可能）",function(e){
      if(e){
        del();
      }
    });
  }); 
});

function change(){
  $.post(
    "changedevice.php",
    {
      "did":$('#did').val(),
      "category": $('#category').val(),
      "maker": $('#maker').val(),
      "type": $('#type').val(),
      "lot": $('#lot').val(),
      "buydate": $('#buydate').val(),
      "owner": $('#owner').val(),
      "desc":$('#desc').val()
    },
    function(data){
      console.log(data);
      location.href="../index.php";
    }
  );
}
function add(){
  $.post(
    "adddevice.php",
    {
      "category": $('#category').val(),
      "maker": $('#maker').val(),
      "type": $('#type').val(),
      "lot": $('#lot').val(),
      "buydate": $('#buydate').val(),
      "owner": $('#owner').val(),
      "desc":$('#desc').val()
    },
    function(data){
       console.log(data);
      location.href="../index.php";
    }
  );
}
function del(){
  $.post(
    "deletedevice.php",
    {
      "did": $('#did').val()    
    },
    function(data){
       console.log(data);
      location.href="../index.php";
    }
  );
}

function reset(){
  $("#toggleCSS").attr("href","../master/js/alertify.default.css");
  alertify.set({
    labels:{
      ok:"OK",
      cancel:"Cancel"
    },
    delay:5000,
    buttonReverse:true,
    buttonFocus:"ok"
  });
}

