<?php
class SpriteFrame extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'sprite_frame';
    $model = array(
        'id'         => array('type'=>Base::PK,                 'com'=>'Id único del frame'),
        'id_sprite'  => array('type'=>Base::NUM,                'com'=>'Id del sprite al que pertenece el frame'),
        'order'      => array('type'=>Base::NUM,                'com'=>'Orden del frame en la animación'),
        'file'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del archivo'),
        'created_at' => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  private $sprite = null;
  
  public function getSprite(){
    if (is_null($this->sprite)){
      $this->loadSprite();
    }
    return $this->sprite;
  }
  
  public function loadSprite(){
    $spr = new Sprite();
    $spr->find(array('id'=>$this->get('id_sprite')));
    $this->sprite = $spr;
  }
  
  public function getUrl(){
    return '/assets/sprite/'.$this->getSprite()->getCategory()->get('slug').'/'.$this->get('file').'.png';
  }
}