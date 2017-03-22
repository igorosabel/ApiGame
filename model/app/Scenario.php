<?php
class Scenario extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'scenario';
    $model = array(
        'id'         => array('type'=>Base::PK,                   'com'=>'Id único de cada escenario'),
        'name'       => array('type'=>Base::TEXT,     'len'=>200, 'com'=>'Nombre del escenario'),
        'data'       => array('type'=>Base::LONGTEXT,             'com'=>'Datos que componen el escenario'),
        'start_x'    => array('type'=>Base::NUM,                  'com'=>'Indica la casilla X de la que se sale'),
        'start_y'    => array('type'=>Base::NUM,                  'com'=>'Indica la casilla Y de la que se sale'),
        'initial'    => array('type'=>Base::BOOL,                 'com'=>'Indica si es el escenario inicial 1 o no 0'),
        'created_at' => array('type'=>Base::CREATED,              'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,              'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}