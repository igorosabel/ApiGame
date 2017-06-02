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
  
  private $sprite_start = null;
  private $sprite_end   = null;
  
  public function loadSprites(){
    if (is_null($this->sprite_start)){
      $sprs = new Sprite();
      $sprs->find(array('id'=>$this->get('sprite_start')));
      $this->sprite_start = $sprs;
    }
    if (is_null($this->sprite_end)){
      $spre = new Sprite();
      $spre->find(array('id'=>$this->get('sprite_end')));
      $this->sprite_end = $spre;
    }
  }
  
  public function getSpriteStart(){
    return $this->sprite_start;
  }
  
  public function getSpriteEnd(){
    return $this->sprite_end;
  }
}