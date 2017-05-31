<?php
class Interactive extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'interactive';
    $model = array(
        'id'           => array('type'=>Base::PK,                 'com'=>'Id del elemento interactivo'),
        'name'         => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del elemento'),
        'sprite_start' => array('type'=>Base::NUM,                'com'=>'Sprite inicial del elemento'),
        'sprite_end'   => array('type'=>Base::NUM,                'com'=>'Sprite final del elemento'),
        'created_at'   => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at'   => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}