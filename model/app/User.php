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
}