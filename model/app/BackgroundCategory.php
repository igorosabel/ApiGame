<?php
class BackgroundCategory extends OBase{
  function __construct(){
    $model_name = get_class($this);
    $tablename  = 'background_category';
    $model = array(
        'id'         => array('type'=>Base::PK,                 'com'=>'Id único de cada categoría'),
        'name'       => array('type'=>Base::TEXT,    'len'=>50, 'com'=>'Nombre de la categoría'),
        'created_at' => array('type'=>Base::CREATED,            'com'=>'Fecha de creación del registro'),
        'updated_at' => array('type'=>Base::UPDATED,            'com'=>'Fecha de última modificación del registro')
    );

    parent::load($model_name,$tablename,$model);
  }
  
  private $backgrounds = null;
  
  public function setBackgrounds($b){
    $this->backgrounds = $b;
  }
  
  public function getBackgrounds(){
    if (is_null($this->backgrounds)){
      $this->loadBackgrounds();
    }
    return $this->backgrounds;
  }
  
  public function loadBackgrounds(){
    $sql = "SELECT * FROM `background` WHERE `id_category` = ".$this->get('id');
    $this->db->query($sql);
    $list = array();
    
    while ($res=$this->db->next()){
      $bck = new Background();
      $bck->update($res);
      
      array_push($list, $bck);
    }
    
    $this->setBackgrounds($list);
  }

  public function deleteFull(){
    $bcks = $this->getBackgrounds();
    foreach ($bcks as $bck){
      $bck->delete();
    }
    $this->delete();
  }
}