<?php
class CharacterFrame extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'character_frame';
    $model = array(
        'id'           => array('type'=>Base::PK,                 'com'=>'Id único de cada frame del tipo de personaje'),
        'id_character' => array('type'=>Base::NUM,                'com'=>'Id del tipo de personaje al que pertenece el frame'),
        'orientation'  => array('type'=>Base::TEXT,    'len'=>5,  'com'=>'Orientación de la imagen del frame'),
        'order'        => array('type'=>Base::NUM,                'com'=>'Orden del frame en la animación'),
        'file'         => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre del archivo'),
        'created_at'   => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at'   => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  public function deleteFull(){
    global $c;
    $ruta = $c->getDir('assets').'character/'.$this->getCharacter()->get('slug').'/'.$this->get('file').'.png';
    if (file_exists($ruta)){
      unlink($ruta);
    }
    $this->delete();
  }
  
  private $character = null;
  
  public function getCharacter(){
    if (is_null($this->character)){
      $this->loadCharacter();
    }
    return $this->character;
  }
  
  public function setCharacter($char){
    $this->character = $char;
  }
  
  public function loadCharacter(){
    $char = new Character();
    $char->find(array('id'=>$this->get('id_character')));
    $this->setCharacter($char);
  }
  
  public function getUrl(){
    return '/assets/character/'.$this->getCharacter()->get('slug').'/'.$this->get('file').'.png';
  }
}