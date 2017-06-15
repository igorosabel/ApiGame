<?php
class Character extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'character';
    $model = array(
        'id'         => array('type'=>Base::PK,                 'com'=>'Id único de cada tipo de personaje'),
        'name'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del tipo de personaje'),
        'slug'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Slug del nombre del tipo de personaje'),
        'file_up'    => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Imagen del personaje al mirar hacia arriba'),
        'file_down'  => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Imagen del personaje al mirar hacia abajo'),
        'file_left'  => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Imagen del personaje al mirar hacia la izquierda'),
        'file_right' => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Imagen del personaje al mirar hacia la derecha'),
        'is_npc'     => array('type'=>Base::BOOL,               'com'=>'Indica si el tipo de personaje es un NPC'),
        'is_enemy'   => array('type'=>Base::BOOL,               'com'=>'Indica si el tipo de personaje es un enemigo'),
        'health'     => array('type'=>Base::NUM,                'com'=>'Salud del tipo de personaje'),
        'attack'     => array('type'=>Base::NUM,                'com'=>'Daño que hace el tipo de personaje'),
        'speed'      => array('type'=>Base::NUM,                'com'=>'Velocidad el tipo de personaje'),
        'drops'      => array('type'=>Base::NUM,                'com'=>'Id del elemento que da el tipo de personaje'),
        'created_at' => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  public function deleteFull(){
    global $c;
    
    $frames = $this->getFrames();
    foreach ($frames as $fr){
      $fr->setCharacter($this);
      $fr->deleteFull();
    }
    
    $ruta_up = $c->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_up').'.png';
    if (file_exists($ruta_up)){
      unlink($ruta_up);
    }
    $ruta_down = $c->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_down').'.png';
    if (file_exists($ruta_down)){
      unlink($ruta_down);
    }
    $ruta_left = $c->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_left').'.png';
    if (file_exists($ruta_left)){
      unlink($ruta_left);
    }
    $ruta_right = $c->getDir('assets').'character/'.$this->get('slug').'/'.$this->get('file_right').'.png';
    if (file_exists($ruta_right)){
      unlink($ruta_right);
    }
    
    $this->delete();
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
    $sql = "SELECT * FROM `character_frame` WHERE `id_character` = ".$this->get('id')." ORDER BY `order`";
    $this->db->query($sql);
    while ($res=$this->db->next()){
      $charf = new CharacterFrame();
      $charf->update($res);
      array_push($list, $charf);
    }
    $this->frames = $list;
  }
}