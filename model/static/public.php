<?php
  /*
   * Clase con funciones generales para usar a lo largo del sitio
   */
class stPublic{
  public static function getScenarios(){
    $ret = array();
    $db = new ODB();
    $sql = "SELECT * FROM `scenario` ORDER BY `name` ASC";
    $db->query($sql);
    
    while ($res=$db->next()){
      $sce = new Scenario();
      $sce->update($res);
      
      array_push($ret, $sce);
    }
    
    return $ret;
  }
  
  public static function getBackgrounds(){
    $ret = array();
    $db = new ODB();
    $sql = "SELECT * FROM `background`";
    $db->query($sql);
    
    while ($res=$db->next()){
      $bck = new Background();
      $bck->update($res);
      
      array_push($ret, $bck);
    }
    
    return $ret;
  }
  
  public static function getBackgroundsData($list){
    $data = array();
    
    foreach ($list as $bck){
      $item = array(
        'id' => $bck->get('id'),
        'name' => urlencode($bck->get('name')),
        'class' => $bck->get('class'),
        'crossable' => $bck->get('crossable')
      );
      $data['bck_'.$item['id']] = $item;
    }
    return $data;
  }
}