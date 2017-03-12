<?php
class User extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'user';
    $model = array(
        'id'         => array('type'=>Base::PK,                 'com'=>'Id único de cada usuario'),
        'email'      => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Email del usuario'),
        'pass'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Contraseña del usuario'),
        'created_at' => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  public function login($email,$pass){
    $ret = false;
    if ($this->find(array('email'=>$email))){
      if ($this->get('pass')==sha1('gam_'.$pass.'_gam')){
        $ret = true;
      }
    }
    return $ret;
  }
  
  private $games = null;
  
  public function setGames($g){
    $this->games = $g;
  }
  
  public function getGames(){
    if (is_null($this->games)){
      $this->loadGames();
    }
    return $this->games;
  }
  
  public function loadGames(){
    $sql = "SELECT * FROM `game` WHERE `id_user` = ".$this->get('id');
    $this->db->query($sql);
    $list = array();
    
    while ($res=$this->db->next()){
      $gam = new Game();
      $gam->update($res);
      
      array_push($list, $gam);
    }
    
    $this->setGames($list);
  }

  public function deleteFull(){
    $games = $this->getGames();
    foreach ($games as $gam){
      $gam->delete();
    }
    $this->delete();
  }
}