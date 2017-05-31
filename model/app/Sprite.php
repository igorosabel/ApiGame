<?php
class Sprite extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'sprite';
    $model = array(
        'id'          => array('type'=>Base::PK,                 'com'=>'Id único de cada fondo'),
        'id_category' => array('type'=>Base::NUM,                'com'=>'Id de la categoría a la que pertenece'),
        'name'        => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del fondo'),
        'file'        => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del archivo'),
        'crossable'   => array('type'=>Base::BOOL,               'com'=>'Indica si la casilla se puede cruzar 1 o no 0'),
        'breakable'   => array('type'=>Base::BOOL,               'com'=>'Indica si se puede romper 1 o no 0'),
        'grabbable'   => array('type'=>Base::BOOL,               'com'=>'Indica si se puede coger 1 o no 0'),
        'pickable'    => array('type'=>Base::BOOL,               'com'=>'Indica si se puede coger al inventario 1 o no 0'),
        'width'       => array('type'=>Base::NUM,                'com'=>'Anchura del sprite en casillas'),
        'height'      => array('type'=>Base::NUM,                'com'=>'Altura del sprite en casillas'),
        'created_at'  => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}