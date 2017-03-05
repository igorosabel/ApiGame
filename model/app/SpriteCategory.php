<?php
class SpriteCategory extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'sprite_category';
    $model = array(
        'id'         => array('type'=>Base::PK,                 'com'=>'Id único de cada categoría'),
        'name'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre de la categoría'),
        'created_at' => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  private $sprites = null;
  
  public function setSprites($s){
    $this->sprites = $s;
  }
  
  public function getSprites(){
    if (is_null($this->sprites)){
      $this->loadSprites();
    }
    return $this->sprites;
  }
  
  public function loadSprites(){
    $sql = "SELECT * FROM `sprite` WHERE `id_category` = ".$this->get('id');
    $this->db->query($sql);
    $list = array();
    
    while ($res=$this->db->next()){
      $spr = new Sprite();
      $spr->update($res);
      
      array_push($list, $spr);
    }
    
    $this->setSprites($list);
  }
}