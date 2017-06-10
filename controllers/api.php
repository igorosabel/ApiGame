<?php
  /*
   * Función para iniciar sesión
   */
  function executeLogin($req, $t){
    global $c, $s;

    $status = 'ok';
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);
    
    if ($email===false || $pass===false){
      $status = 'error';
    }
    
    if ($status=='ok'){
      $email = urldecode($email);
      $pass  = urldecode($pass);
      $u = new User();
      if ($u->login($email,$pass)){
        $s->addParam('logged', true);
        $s->addParam('id',     $u->get('id'));
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->process();
  }
  
  /*
   * Función para registrar un nuevo usuario
   */
  function executeRegister($req, $t){
    global $c, $s;

    $status = 'ok';
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);
    
    if ($email===false || $pass===false){
      $status = 'error';
    }
    
    if ($status=='ok'){
      $u = new User();
      $email = urldecode($email);
      $pass  = urldecode($pass);
      
      if ($u->find(array('email'=>$email))){
        $status = 'error';
      }
      else{
        $u->set('email', $email);
        $u->set('pass',  sha1('gam_'.$pass.'_gam'));
        $u->save();
        
        for ($i=0;$i<3;$i++){
          $game = new Game();
          $game->set('id_user', $u->get('id'));
          $game->set('name', null);
          $game->set('id_scenario', null);
          $game->set('position_x', null);
          $game->set('position_y', null);
          $game->save();
        }
        
        $s->addParam('logged', true);
        $s->addParam('id',     $u->get('id'));
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->process();
  }
  
  /*
   * Función para crear una nueva partida
   */
  function executeNewGame($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);
    $name   = Base::getParam('name', $req['url_params'], false);
    
    if ($id===false || $name===false){
      $status = 'error';
    }
    
    if ($status=='ok'){
      $name = urldecode($name);
      $game = new Game();
      if ($game->find(array('id'=>$id))){
        $scn = stPublic::getStartScenario();

        $game->set('name', $name);
        $game->set('id_scenario', $scn->get('id'));
        $game->set('position_x', $scn->get('start_x'));
        $game->set('position_y', $scn->get('start_y'));
        $game->save();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->process();
  }
  
  /*
   * Función para añadir un nuevo escenario
   */
  function executeNewScenario($req, $t){
    global $c, $s;

    $status = 'ok';
    $name   = Base::getParam('name', $req['url_params'], false);
    $id     = 0;
    
    if ($name===false){
      $status = 'error';
    }
    
    if ($status=='ok'){
      $name = urldecode($name);
      $scn = new Scenario();
      $scn->set('name', $name);
      
      // Creo escenario vacío
      $data = array();
      for ($i=0;$i<$c->getExtra('height');$i++){
        $row = array();
        for ($j=0;$j<$c->getExtra('width');$j++){
          array_push($row, new stdClass);
        }
        array_push($data, $row);
      }
      
      $scn->set('data', json_encode($data));
      $scn->save();
      
      $id = $scn->get('id');
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->add('name',   $name);
    $t->process();
  }
  
  /*
   * Función para guardar un escenario editado
   */
  function executeSaveScenario($req, $t){
    global $c, $s;

    $status   = 'ok';
    $id       = Base::getParam('id',       $req['url_params'], false);
    $name     = Base::getParam('name',     $req['url_params'], false);
    $scenario = Base::getParam('scenario', $req['url_params'], false);
    $start_x  = Base::getParam('start_x',  $req['url_params'], false);
    $start_y  = Base::getParam('start_y',  $req['url_params'], false);
    $initial  = Base::getParam('initial',  $req['url_params'], false);
    
    if ($id===false || $name===false || $scenario===false || $start_x===false || $start_y===false || $initial===false){
      $status = 'error';
    }
    
    if ($status=='ok'){
      $scn = new Scenario();
      if ($scn->find(array('id'=>$id))){
        $scn->set('name',    urldecode($name));
        $scn->set('data',    $scenario);
        $scn->set('start_x', $start_x);
        $scn->set('start_y', $start_y);
        $scn->set('initial', $initial);
        $scn->save();

      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->process();
  }
  
  /*
   * Función para guardar una categoría de fondos
   */
  function executeSaveBackgroundCategory($req, $t){
    global $c, $s;

    $status = 'ok';
    $name   = Base::getParam('name', $req['url_params'], false);
    $id     = Base::getParam('id',   $req['url_params'], false);
    $is_new = 'true';

    if ($name===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $name = urldecode($name);
      $id   = (int)$id;
      $bckc = new BackgroundCategory();
      if ($id!==0){
        $bckc->find(array('id'=>$id));
        $is_new = 'false';
      }
      $bckc->set('name', $name);
      $bckc->set('slug', Base::slugify($name));
      $bckc->save();

      $id = $bckc->get('id');
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->add('name',   $name);
    $t->add('is_new', $is_new);
    $t->process();
  }

  /*
   * Función para borrar una categoría de fondos
   */
  function executeDeleteBackgroundCategory($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $bckc = new BackgroundCategory();
      if ($bckc->find(array('id'=>$id))){
        $bckc->deleteFull();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->process();
  }

  /*
   * Función para guardar un fondo
   */
  function executeSaveBackground($req, $t){
    $status      = 'ok';
    $id          = Base::getParam('id',          $req['url_params'], false);
    $id_category = Base::getParam('id_category', $req['url_params'], false);
    $name        = Base::getParam('name',        $req['url_params'], false);
    $file_name   = Base::getParam('file_name',   $req['url_params'], false);
    $file        = Base::getParam('file',        $req['url_params'], false);
    $crossable   = Base::getParam('crossable',   $req['url_params'], false);
    $is_new      = 'true';

    if ($id===false || $id_category===false || $name===false || $crossable===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $id    = (int)$id;
      $name  = urldecode($name);

      $bck = new Background();
      if ($id!==0){
        $bck->find(array('id'=>$id));
        $is_new = 'false';
      }
      $bck->set('id_category', $id_category);
      $bck->set('name',        $name);
      if ($file_name!=''){
        $bck->set('file', str_ireplace('.png', '', $file_name));
      }
      $bck->set('crossable',   ($crossable=='true'));
      $bck->save();
      
      if ($file_name!=''){
        $bckc = new BackgroundCategory();
        $bckc->find(array('id'=>$id_category));
        $category = $bckc->get('slug');

        $ruta = $c->getDir('assets').'background/'.$bckc->get('slug').'/'.$file_name;
        stPublic::saveImage($ruta, $file);
      }

      $id = $bck->get('id');
      $saved_file = $spr->get('file');
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',      $status);
    $t->add('id',          $id);
    $t->add('id_category', $id_category);
    $t->add('name',        $name);
    $t->add('saved_file',  $saved_file);
    $t->add('category',    $category);
    $t->add('crossable',   $crossable);
    $t->add('is_new',      $is_new);
    $t->process();
  }
  
  /*
   * Función para borrar un fondo
   */
  function executeDeleteBackground($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $bck = new Background();
      if ($bck->find(array('id'=>$id))){
        // Primero borro el archivo
        $bckc = new BackgroundCategory();
        $bckc->find(array('id'=>$bck->get('id_category')));

        $ruta = $c->getDir('assets').'background/'.$bckc->get('slug').'/'.$bck->get('file').'.png';
        if (file_exists($ruta)){
          unlink($ruta);
        }

        // Luego el registro
        $bck->delete();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->process();
  }
  
  /*
   * Función para guardar una categoría de sprites
   */
  function executeSaveSpriteCategory($req, $t){
    global $c, $s;

    $status = 'ok';
    $name   = Base::getParam('name', $req['url_params'], false);
    $id     = Base::getParam('id',   $req['url_params'], false);
    $is_new = 'true';

    if ($name===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $name = urldecode($name);
      $id   = (int)$id;
      $sprc = new SpriteCategory();
      if ($id!==0){
        $sprc->find(array('id'=>$id));
        $is_new = 'false';
      }
      $sprc->set('name', $name);
      $sprc->set('slug', Base::slugify($name));
      $sprc->save();

      $id = $sprc->get('id');
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->add('name',   $name);
    $t->add('is_new', $is_new);
    $t->process();
  }

  /*
   * Función para borrar una categoría de sprites
   */
  function executeDeleteSpriteCategory($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $sprc = new SpriteCategory();
      if ($sprc->find(array('id'=>$id))){
        $sprc->deleteFull();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->process();
  }
  
  /*
   * Función para obtener los datos de un sprite
   */
  function executeGetSprite($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);
    
    $id_category = 0;
    $name        = '';
    $file        = '';
    $url         = '';
    $crossable   = 'false';
    $width       = 0;
    $height      = 0;
    $frames      = array();

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $spr = new Sprite();
      if ($spr->find(array('id'=>$id))){
        $id_category = $spr->get('id_category');
        $name        = $spr->get('name');
        $file        = $spr->get('file');
        $url         = $spr->getUrl();
        $crossable   = $spr->get('crossable') ? 'true' : 'false';
        $width       = $spr->get('width');
        $height      = $spr->get('height');
        $frames      = $spr->getFrames();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',      $status);
    $t->add('id',          $id);
    $t->add('id_category', $id_category);
    $t->add('name',        $name);
    $t->add('file',        $file);
    $t->add('url',         $url);
    $t->add('crossable',   $crossable);
    $t->add('width',       $width);
    $t->add('height',      $height);
    $t->addPartial('frames', 'api/getSpriteFrames', array('frames' => $frames,'extra'=>'nourlencode'));
    $t->process();
  }

  /*
   * Función para guardar un fondo
   */
  function executeSaveSprite($req, $t){
    global $c;
    $status      = 'ok';
    $id          = Base::getParam('id',          $req['url_params'], false);
    $id_category = Base::getParam('id_category', $req['url_params'], false);
    $name        = Base::getParam('name',        $req['url_params'], false);
    $file        = Base::getParam('file',        $req['url_params'], false);
    $data        = Base::getParam('data',        $req['url_params'], false);
    $width       = Base::getParam('width',       $req['url_params'], false);
    $height      = Base::getParam('height',      $req['url_params'], false);
    $crossable   = Base::getParam('crossable',   $req['url_params'], false);
    $frames      = Base::getParam('frames',      $req['url_params'], false);
    $is_new      = 'true';
    $url         = '';
    $category    = '';

    if ($id===false || $id_category===false || $name===false || $width===false || $height===false || $crossable===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $id    = (int)$id;
      $name  = urldecode($name);
      $frames = json_decode($frames,true);

      $spr = new Sprite();
      if ($id!==0){
        $spr->find(array('id'=>$id));
        $is_new = 'false';
      }
      $spr->set('id_category', $id_category);
      $spr->set('name',        $name);
      if ($file!=''){
        $spr->set('file', str_ireplace('.png', '', $file));
      }
      $spr->set('width',     $width);
      $spr->set('height',    $height);
      $spr->set('crossable', ($crossable=='true'));
      $spr->save();

      if ($data!=''){
        $ruta = $c->getDir('assets').'sprite/'.$spr->getCategory()->get('slug').'/'.$file;
        stPublic::saveImage($ruta, $data);
      }
      
      if (count($frames)>0){
        $order = 0;
        foreach ($frames as $frame){
          $order++;
          
          $fr = new SpriteFrame();
          if ($frame['id']!=0){
            $fr->find(array('id'=>$frame['id']));
          }
          $fr->set('id_sprite',$spr->get('id'));
          $fr->set('order',$order);
          
          if (array_key_exists('data', $frame)){
            if ($frame['file']!=$fr->get('file') && $fr->get('file')!=''){
              $ruta = $c->getDir('assets').'sprite/'.$spr->getCategory()->get('slug').'/'.$fr->get('file');
              unlink($ruta);
            }
            $ruta = $c->getDir('assets').'sprite/'.$spr->getCategory()->get('slug').'/'.$frame['file'];
            stPublic::saveImage($ruta, $frame['data']);
          }
          if (array_key_exists('delete', $frame)){
            $fr->deleteFull();
          }
          else{
            if (array_key_exists('file', $frame)){
              $fr->set('file',str_ireplace('.png', '', $frame['file']));
            }
            $fr->save();
          }
        }
        $spr->set('frames',$order);
        $spr->save();
      }
      
      $id  = $spr->get('id');
      $url = $spr->getUrl();
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',      $status);
    $t->add('id',          $id);
    $t->add('id_category', $id_category);
    $t->add('name',        $name);
    $t->add('file',        $file);
    $t->add('url',         $url);
    $t->add('width',       $width);
    $t->add('height',      $height);
    $t->add('crossable',   $crossable);
    $t->add('is_new',      $is_new);
    $t->process();
  }
  
  /*
   * Función para borrar un sprite
   */
  function executeDeleteSprite($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',   $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $spr = new Sprite();
      if ($spr->find(array('id'=>$id))){
        // Primero borro el archivo
        $sprc = new SpriteCategory();
        $sprc->find(array('id'=>$spr->get('id_category')));
      
        $ruta = $c->getDir('assets').'sprite/'.$sprc->get('slug').'/'.$spr->get('file').'.png';
        if (file_exists($ruta)){
          unlink($ruta);
        }
        
        // Luego el registro
        $spr->delete();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->process();
  }
  
  /*
   * Función para guardar un elemento interactivo
   */
  function executeSaveInteractive($req, $t){
    global $c, $s;

    $status       = 'ok';
    $id           = Base::getParam('id',           $req['url_params'], false);
    $name         = Base::getParam('name',         $req['url_params'], false);
    $sprite_start = Base::getParam('sprite_start', $req['url_params'], false);
    $sprite_end   = Base::getParam('sprite_end',   $req['url_params'], false);
    $url_start    = '';
    $is_new       = 'true';

    if ($id===false || $name===false || $sprite_start===false || $sprite_end===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $id    = (int)$id;
      $name = urldecode($name);
      
      $int = new Interactive();
      if ($id!==0){
        $int->find(array('id'=>$id));
        $is_new = 'false';
      }
      $int->set('name',         $name);
      $int->set('sprite_start', $sprite_start);
      $int->set('sprite_end',   $sprite_end);
      
      $int->save();
      
      $id = $int->get('id');
      $int->loadSprites();
      
      $url_start = '/assets/sprite/'.$int->getSpriteStart()->getCategory()->get('slug').'/'.$int->getSpriteStart()->get('file').'.png';
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',       $status);
    $t->add('is_new',       $is_new);
    $t->add('id',           $id);
    $t->add('name',         $name);
    $t->add('url_start',    $url_start);
    $t->add('sprite_start', $sprite_start);
    $t->add('sprite_end',   $sprite_end);
    $t->process();
  }
  
  /*
   * Función para borrar un elemento interactivo
   */
  function executeDeleteInteractive($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $int = new Interactive();
      if ($int->find(array('id'=>$id))){
        $int->delete();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->process();
  }
  
  /*
   * Función para guardar un usuario
   */
  function executeSaveUser($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id',    $req['url_params'], false);
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);

    if ($id===false || $email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $email = urldecode($email);
      $pass  = urldecode($pass);
      
      $u = new User();
      if ($u->find(array('id'=>$id))){
        $u->set('email', $email);
        if ($pass!=''){
          $u->set('pass',  sha1('gam_'.$pass.'_gam'));
        }
        $u->save();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->add('email',  $email);
    $t->process();
  }
  
  /*
   * Función para borrar un usuario
   */
  function executeDeleteUser($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $u = new User();
      if ($u->find(array('id'=>$id))){
        $u->deleteFull();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->process();
  }
  
  /*
   * Función para guardar una partida
   */
  function executeSaveGame($req, $t){
    global $c, $s;

    $status      = 'ok';
    $id          = Base::getParam('id',          $req['url_params'], false);
    $name        = Base::getParam('name',        $req['url_params'], false);
    $id_scenario = Base::getParam('id_scenario', $req['url_params'], false);
    $x           = Base::getParam('x',           $req['url_params'], false);
    $y           = Base::getParam('y',           $req['url_params'], false);
    $scenario    = '';

    if ($id===false || $name===false || $id_scenario===false || $x===false || $y===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $name = urldecode($name);
      $game = new Game();
      if ($game->find(array('id'=>$id))){
        $game->set('name',        $name);
        $game->set('id_scenario', $id_scenario);
        $game->set('position_x',  $x);
        $game->set('position_y',  $y);
        $game->save();
        
        $scenario = $game->getScenario()->get('name');
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',      $status);
    $t->add('id',          $id);
    $t->add('name',        $name);
    $t->add('id_scenario', $id_scenario);
    $t->add('scenario',    $scenario);
    $t->add('x',           $x);
    $t->add('y',           $y);
    $t->process();
  }
  
  /*
   * Función para borrar una partida
   */
  function executeDeleteGame($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);

    if ($id===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $game = new Game();
      if ($game->find(array('id'=>$id))){
        $game->set('name',        null);
        $game->set('id_scenario', null);
        $game->set('position_x',  null);
        $game->set('position_y',  null);
        $game->save();
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('id',     $id);
    $t->process();
  }