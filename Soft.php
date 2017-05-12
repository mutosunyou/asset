<?php
require_once('master/prefix.php');

class Soft 
{
  public $id;
  public $name;
  public $ver;
  public $lot;
  public $license;
  public $buydate;
  public $description;
  public $isalive;

  function initWithID($sid)
  { 
    //データベースのデータを変数に格納
    $sql = 'select * from soft where id = '.$sid;
    $rst = selectData(DB_NAME, $sql);

    $this->id = $sid;
    $this->name = $rst[0]['name'];
    $this->ver = $rst[0]['maker'];
    $this->lot = $rst[0]['lot'];
    $this->license = $rst[0]['license'];
    $this->buydate = $rst[0]['buydate'];
    $this->description = $rst[0]['description'];
    $this->isalive = $rst[0]['isalive'];

    function del(){
      if ($this->isalive == 0) {
        $sql = 'update soft set isalive = 0 where id = '.$this->id;
        deleteFrom(DB_NAME, $sql);
        $this->reload();
      }
    }
    function setName($cname){
      $cname = myescape($cname);
      $sql = 'update soft set name = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setVer($cname){
      $cname = myescape($cname);
      $sql = 'update soft set ver = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setLot($cname){
      $cname = myescape($cname);
      $sql = 'update soft set lot = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }
    function setLicense($cname){
      $cname = myescape($cname);
      $sql = 'update soft set license = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }   
    function setBuydate($cname){
      $cname = myescape($cname);
      $sql = 'update soft set buydate = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }   
    function setDescription($cname){
      $cname = myescape($cname);
      $sql = 'update soft set description = '.$cname.' where id = '.$this->id;
      deleteFrom(DB_NAME, $sql);
      $this->reload();
    }

    function reload(){
    $this->initWithID($this->id);
  }
}


