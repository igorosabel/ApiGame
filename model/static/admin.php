<?php
/*
 * Clase con funciones generales para usar en el apartado admin
 */
class stAdmin{
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
}