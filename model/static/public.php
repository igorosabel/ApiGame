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

  public static function getStartScenario(){
    $db = new ODB();
    $sql = "SELECT * FROM `scenario` WHERE `initial` = 1";
    $db->query($sql);

    $res = $db->next();
    $scn = new Scenario();
    $scn->update($res);

    return $scn;
  }
  
  public static function getBackgroundCategories(){
    $db = new ODB();
    $sql = "SELECT * FROM `background_category`";
    $db->query($sql);
    $bckcs = array();
    while ($res=$db->next()){
      $bckc = new BackgroundCategory();
      $bckc->update($res);
      
      $bckcs['bckc_'.$bckc->get('id')] = $bckc;
    }
    
    return $bckcs;
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
          'class' => $bck->get('file'),
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

  public static function getAssetsData($scn){
    $ret = array('assets'=>array(), 'bck'=>array(), 'spr'=>array());
    $ids = array('bck'=>array(), 'spr'=>array());

    $scenario = json_decode($scn,true);
    for ($y=0; $y<count($scenario); $y++){
      for ($x=0; $x<count($scenario[$y]); $x++){
        foreach ($scenario[$y][$x] as $type => $val){
          $temp = array('type'=>$type, 'x'=>($x+1), 'y'=>($y+1), 'id'=>(int)$val);
          array_push($ret['assets'], $temp);
          if (!in_array((int)$val, $ids[$type])) {
            array_push($ids[$type], (int)$val);
          }
        }
      }
    }

    $db = new ODB();
    if (count($ids['bck'])>0){
      $bckcs = self::getBackgroundCategories();
      
      $sql = 'SELECT * FROM `background` WHERE `id` IN ('.implode(',', $ids['bck']).')';
      $db->query($sql);
  
      while ($res=$db->next()){
        $bck = new Background();
        $bck->update($res);
        $ret['bck']['bck_'.$bck->get('id')] = array('url' => $bckcs['bckc_'.$bck->get('id_category')]->get('slug').'/'.$bck->get('file'), 'crossable' => $bck->get('crossable'));
      }
    }
    if (count($ids['spr'])>0){
      $sprcs = self::getSpriteCategories();
      
      $sql = 'SELECT * FROM `sprite` WHERE `id` IN ('.implode(',', $ids['spr']).')';
      $db->query($sql);
  
      while ($res=$db->next()){
        $spr = new Sprite();
        $spr->update($res);
        $ret['spr']['spr_'.$spr->get('id')] = array('url' => $sprcs['sprc_'.$spr->get('id_category')]->get('slug').'/'.$spr->get('file'), 'crossable' => $spr->get('crossable'));
      }
    }

    return $ret;
  }
  
  public static function getSpriteCategories(){
    $db = new ODB();
    $sql = "SELECT * FROM `sprite_category`";
    $db->query($sql);
    $sprcs = array();
    while ($res=$db->next()){
      $sprc = new SpriteCategory();
      $sprc->update($res);
      
      $sprcs['sprc_'.$sprc->get('id')] = $sprc;
    }
    
    return $sprcs;
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
          'class' => $spr->get('file'),
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
  
  public static function saveImage($ruta, $base64_string) {
    if (file_exists($ruta)){
      unlink($ruta);
    }

    $ifp = fopen($ruta, "wb");
    $data = explode(',', $base64_string);
    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp);
  }
  
  public static function getInteractives(){
    $ret = array();
    $db = new ODB();
    $sql = "SELECT * FROM `interactive` ORDER BY `name`";
    $db->query($sql);
    
    while ($res=$db->next()){
      $int = new Interactive();
      $int->update($res);
      $int->loadSprites();
      
      array_push($ret, $int);
    }
    
    return $ret;
  }
}