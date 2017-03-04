<?php
class Connection extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'connection';
    $model = array(
        'id_from'    => array('type'=>Base::PK,      'com'=>'Id de la categoría en la que está el producto', 'incr'=>false),
        'id_to'      => array('type'=>Base::PK,      'com'=>'Id del producto',                               'incr'=>false),
        'direction'  => array('type'=>Base::NUM,     'com'=>'Id del producto'),
        'created_at' => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model,array('id_from','id_to'));
  }
}