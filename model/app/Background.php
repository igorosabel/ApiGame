<?php
class Background extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'background';
    $model = array(
        'id'         => array('type'=>Base::PK,                 'com'=>'Id único de cada fondo'),
        'name'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del fondo'),
        'class'      => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre de la clase'),
        'crossable'  => array('type'=>Base::BOOL,               'com'=>'Indica si la casilla se puede cruzar 1 o no 0'),
        'created_at' => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}