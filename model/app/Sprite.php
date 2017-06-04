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
        'width'       => array('type'=>Base::NUM,                'com'=>'Anchura del sprite en casillas'),
        'height'      => array('type'=>Base::NUM,                'com'=>'Altura del sprite en casillas'),
        'frames'      => array('type'=>Base::NUM,                'com'=>'Número de frames para animar el sprite'),
        'created_at'  => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at'  => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  private $category = null;
  
  public function getCategory(){
    if (is_null($this->category)){
      $this->loadCategory();
    }
    return $this->category;
  }
  
  public function loadCategory(){
    $sprc = new SpriteCategory();
    $sprc->find(array('id'=>$this->get('id_category')));
    $this->category = $sprc;
  }
  
  private $frames = null;
  
  public function getFrames(){
    if (is_null($this->frames)){
      $this->loadFrames();
    }
    return $this->frames;
  }
  
  public function loadFrames(){
    $list = array();
    $sql = "SELECT * FROM `sprite_frame` WHERE `id_sprite` = ".$this->get('id')." ORDER BY `order`";
    $this->db->query($sql);
    while ($res=$this->db->next()){
      $sprf = new SpriteFrame();
      $sprf->update($res);
      array_push($list, $sprf);
    }
    $this->frames = $list;
  }
  
  public function getUrl(){
    return '/assets/sprite/'.$this->getCategory()->get('slug').'/'.$this->get('file').'.png';
  }
}