<?php
class Game extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'game';
    $model = array(
        'id'          => array('type'=>Base::PK,                 'com'=>'Id único de cada partida'),
        'id_user'     => array('type'=>Base::NUM,                'com'=>'Id del usuario al que pertenece la partida'),
        'name'        => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del personaje'),
        'id_scenario' => array('type'=>Base::NUM,                'com'=>'Id del escenario en el que está el usuario'),
        'position_x'  => array('type'=>Base::NUM,                'com'=>'Última posición X guardada del jugador'),
        'position_y'  => array('type'=>Base::NUM,                'com'=>'Última posición Y guardada del jugador'),
        'created_at'  => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}