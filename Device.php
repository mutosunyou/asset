<?php
require_once('master/prefix.php');

class Device 
{
  public $id;
  public $category;
  public $maker;
  public $type;
  public $lot;
  public $buydate;
  public $owner;
  public $description;
  public $isalive;
  public $softs;

  function initWithID($did)
  { 
    //データベースのデータを変数に格納
    $sql = 'select * from device where id = '.$did;
    $rst = selectData(DB_NAME, $sql);

    $this->id = $did;
    $this->category = $rst[0]['category'];
    $this->maker = $rst[0]['maker'];
    $this->type = $rst[0]['type'];
    $this->lot = $rst[0]['lot'];
    $this->buydate = $rst[0]['buydate'];
    $this->owner = $rst[0]['owner'];
    $this->description = $rst[0]['description'];
    $this->isalive = $rst[0]['isalive'];

    //responsible
    $sql = 'select softID from link where deviceID = '.$this->id;
    $rst = selectData(DB_NAME, $sql);

    $this->softs = array();
    for ($i=0; $i < count($rst); $i++) {
      $ps = new Soft;
      $ps->initWithID($rst[$i]['softID']);
      $this->softs[] = $ps;
    }

    function del(){
      if ($this->isalive == 0) {
        $sql = 'update device set isalive = 0 where id = '.$this->id;
        deleteFrom(DB_NAME, $sql);
        $this->reload();
      }
    }
    function setCategory($cname){
      $sql = 'update device set category = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setMaker($cname){
      $cname = myescape($cname);
      $sql = 'update device set maker = "'.$cname.'" where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setType($cname){
      $cname = myescape($cname);
      $sql = 'update device set type = "'.$cname.'" where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setLot($cname){
      $cname = myescape($cname);
      $sql = 'update device set lot = "'.$cname.'" where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setBuydate($cname){
      $cname = myescape($cname);
      $sql = 'update device set buydate = "'.$cname.'" where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setOwner($cname){
      $cname = myescape($cname);
      $sql = 'update device set owner = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setDescription($cname){
      $cname = myescape($cname);
      $sql = 'update device set description = "'.$cname.'" where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }

    function reload(){
      $this->initWithID($this->id);
    }
  }


