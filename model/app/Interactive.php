<?php
class Interactive extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'interactive';
    $model = array(
        'id'               => array('type'=>Base::PK,                 'com'=>'Id del elemento interactivo'),
        'name'             => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del elemento'),
        'type'             => array('type'=>Base::NUM,                'com'=>'Tipo del elemento'),
        'activable'        => array('type'=>Base::BOOL,               'com'=>'Indica si el elemento se puede activar'),
        'pickable'         => array('type'=>Base::BOOL,               'com'=>'Indica si el elemento se puede coger al inventario'),
        'grabbable'        => array('type'=>Base::BOOL,               'com'=>'Indica si el elemento se puede coger'),
        'breakable'        => array('type'=>Base::BOOL,               'com'=>'Indica si el elemento se puede romper'),
        'crossable'        => array('type'=>Base::BOOL,               'com'=>'Indica si el elemento se puede cruzar'),
        'crossable_active' => array('type'=>Base::BOOL,               'com'=>'Indica si el elemento se puede cruzar una vez activao'),
        'sprite_start'     => array('type'=>Base::NUM,                'com'=>'Sprite inicial del elemento'),
        'sprite_active'    => array('type'=>Base::NUM,                'com'=>'Sprite del elemento al activar'),
        'drops'            => array('type'=>Base::NUM,                'com'=>'Id del elemento que se obtiene al activar o romperlo'),
        'quantity'         => array('type'=>Base::NUM,                'com'=>'Número de elementos que se obtienen al activar o romper'),
        'active_time'      => array('type'=>Base::NUM,                'com'=>'Número de segundos que se mantiene activo, 0 ilimitado'),
        'created_at'       => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at'       => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  private $sprite_start = null;
  private $sprite_active   = null;
  
  public function loadSpriteStart(){
    $sprs = new Sprite();
    $sprs->find(array('id'=>$this->get('sprite_start')));
    $this->sprite_start = $sprs;
  }
  
  public function loadSpriteActive(){
    $spra = new Sprite();
    $spra->find(array('id'=>$this->get('sprite_active')));
    $this->sprite_start = $spra;
  }
  
  public function getSpriteStart(){
    if (is_null($this->sprite_start)){
      $this->loadSpriteStart();
    }
    return $this->sprite_start;
  }
  
  public function getSpriteActive(){
    if (is_null($this->sprite_active)){
      $this->loadSpriteActive();
    }
    return $this->sprite_active;
  }
}