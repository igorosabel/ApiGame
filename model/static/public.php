<?php
  /*
   * Clase con funciones generales para usar a lo largo del sitio
   */
class stPublic{
  public static function getGames($id_user){
    $ret = array();
    $db = new ODB();
    $sql = sprintf("SELECT * FROM `game` WHERE `id_user` = %s", $id_user);
    $db->query($sql);
    
    while ($res = $db->next()){
      $game = new Game();
      $game->update($res);
      
      array_push($ret, $game);
    }
    
    return $ret;
  }
  
  public static function getBackgrounds(){
    $ret = array();
    $db = new ODB();
    $sql = "SELECT * FROM `background_category` ORDER BY `name`";
    $db->query($sql);
    
    while ($res=$db->next()){
      $bckc = new BackgroundCategory();
      $bckc->update($res);
      $bckc->loadBackgrounds();
      
      array_push($ret, $bckc);
    }
    
    return $ret;
  }
  
  public static function getBackgroundsData($list){
    $data = array();
    $all = array();
    
    foreach ($list as $bckc){
      $item = array(
        'id' => $bckc->get('id'),
        'name' => urlencode($bckc->get('name')),
        'list' => array()
      );
      
      foreach ($bckc->getBackgrounds() as $bck){
        $item_bck = array(
          'id' => $bck->get('id'),
          'name' => urlencode($bck->get('name')),
          'class' => $bck->get('class'),
          'crossable' => $bck->get('crossable')
        );
        array_push($item['list'], (int)$bck->get('id'));
        $all['bck_'.$bck->get('id')] = $item_bck;
      }
      
      $data['bckc_'.$item['id']] = $item;
    }
    $data['list'] = $all;
    return $data;
  }
  
  public static function getSprites(){
    $ret = array();
    $db = new ODB();
    $sql = "SELECT * FROM `sprite_category` ORDER BY `name`";
    $db->query($sql);
    
    while ($res=$db->next()){
      $sprc = new SpriteCategory();
      $sprc->update($res);
      $sprc->loadSprites();
      
      array_push($ret, $sprc);
    }
    
    return $ret;
  }
  
  public static function getSpritesData($list){
    $data = array();
    $all = array();
    
    foreach ($list as $sprc){
      $item = array(
        'id' => $sprc->get('id'),
        'name' => urlencode($sprc->get('name')),
        'list' => array()
      );
      
      foreach ($sprc->getSprites() as $spr){
        $item_spr = array(
          'id' => $spr->get('id'),
          'name' => urlencode($spr->get('name')),
          'class' => $spr->get('class'),
          'crossable' => $spr->get('crossable'),
          'breakable' => $spr->get('breakable'),
          'grabbable' => $spr->get('breakable')
        );
        array_push($item['list'], (int)$spr->get('id'));
        $all['spr_'.$spr->get('id')] = $item_spr;
      }
      
      $data['sprc_'.$item['id']] = $item;
    }
    $data['list'] = $all;
    return $data;
  }
}