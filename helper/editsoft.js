//初期動作====================================================
$(function() {
  var checkflg=0;
  pname=$('#name').val();
  pver=$('#ver').val();
  plicense=$('#license').val();
  plot=$('#lot').val();
  pbuydate=$('#buydate').val();
  pdesc=$('#desc').val();

  reloadTable();

  $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});//カレンダーから日付を選ぶ

  $('*').change(function(){
    if($('#name').val()!=pname || $('#ver').val()!=pver || $('#license').val()!=plicense || $('#lot').val()!=plot || $('#buydate').val()!=pbuydate || $('#desc').val()!=pdesc ){
      $('#changebtn').removeAttr('disabled');
    }else{
      $('#changebtn').attr('disabled', 'disabled');//disabled属性を付与する
    }
    
    if($('#name').val().length>0){
      $('#addbtn').removeAttr('disabled');
    }else{
      $('#addbtn').attr('disabled', 'disabled');//disabled属性を付与する
    }
  });


  //ボタン======================================================
  //検索ボタン押された
  $('#changebtn').click( function (){
    reset();
    alertify.confirm("このソフトウェア情報を変更しますか？",function(e){
      if(e){
        change();
        reloadTable();
      }
    });
  });
  $('#addbtn').click( function (){
    add();
    reloadTable();
  }); 
  $('#deletebtn').click( function (){
    reset();
    alertify.confirm("このソフトウェアを消去しますか？（DB上では情報は閲覧可能）",function(e){
      if(e){
        del();
        reloadTable();
      }
    });

  }); 
  $('#devicelist').on('click','.dev', function (ev){
    location.href="softlist.php?did="+$(ev.target).attr('devid'); 
  }); 
});

function change(){
  $.post(
    "changesoft.php",
    {
      "sid":$('#sid').val(),
      "did":$('#did').val(),
      "name": $('#name').val(),
      "ver": $('#ver').val(),
      "license": $('#license').val(),
      "lot": $('#lot').val(),
      "buydate": $('#buydate').val(),
      "owner": $('#owner').val(),
      "desc":$('#desc').val()
    },
    function(data){
      console.log(data);
      location.href="../softindex.php";
    }
  );
}
function add(){
  $.post(
    "addsoft.php",
    {
      "did":$('#did').val(),
      "name": $('#name').val(),
      "ver": $('#ver').val(),
      "license": $('#license').val(),
      "lot": $('#lot').val(),
      "buydate": $('#buydate').val(),
      "owner": $('#owner').val(),
      "desc":$('#desc').val()
    },
    function(data){
       console.log(data);
      location.href="../softindex.php";
    }
  );
}
function del(){
  $.post(
    "deletesoft.php",
    {
      "did":$('#did').val(),
      "sid": $('#sid').val()    
    },
    function(data){
       console.log(data);
      location.href="../softindex.php";
    }
  );
}

//アンケートを表示する。
function reloadTable(){
  //console.log($('#sid').val());
  $.post(
    "deviceinsoft.php",
    {
      "sid":$('#sid').val()
    },
    function(data){
      $('#devicelist').html(data);
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

