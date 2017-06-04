<?php
class Inventory extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'inventory';
    $model = array(
        'id'         => array('type'=>Base::PK,      'com'=>'Id único del elemento del inventario'),
        'id_game'    => array('type'=>Base::NUM,     'com'=>'Id de la partida en la que está el elemento'),
        'id_item'    => array('type'=>Base::NUM,     'com'=>'Id del elemento'),
        'order'      => array('type'=>Base::NUM,     'com'=>'Orden del elemento en el inventario'),
        'quantity'   => array('type'=>Base::NUM,     'com'=>'Cantidad del item en el inventario'),
        'created_at' => array('type'=>Base::CREATED, 'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED, 'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
}