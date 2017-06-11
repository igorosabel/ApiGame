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
    $id     = Base::getParam('id', $req['url_params'], false);

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
      $id = 0;
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
    $id     = Base::getParam('id', $req['url_params'], false);

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
   * Función para obtener los datos de un elemento interactivo
   */
  function executeGetInteractive($req, $t){
    global $c, $s;

    $status = 'ok';
    $id     = Base::getParam('id', $req['url_params'], false);

    $name               = '';
    $type               = 0;
    $activable          = 'false';
    $pickable           = 'false';
    $grabbable          = 'false';
    $breakable          = 'false';
    $crossable          = 'false';
    $crossable_active   = 'false';
    $sprite_start_id    = 0;
    $sprite_start_name  = '';
    $sprite_start_url   = '';
    $sprite_active_id   = 0;
    $sprite_active_name = '';
    $sprite_active_url  = '';
    $drops              = 0;
    $quantity           = 0;
    $active_time        = 0;

    if ($id===false){
      $status = 'error';
      $id = 0;
    }

    if ($status=='ok'){
      $int = new Interactive();
      if ($int->find(array('id'=>$id))){
        $spr_start  = $int->getSpriteStart();
        $spr_active = $int->getSpriteActive();

        $name               = $int->get('name');
        $type               = $int->get('type');
        $activable          = $int->get('activable') ? 'true' : 'false';
        $pickable           = $int->get('pickable') ? 'true' : 'false';
        $grabbable          = $int->get('grabbable') ? 'true' : 'false';
        $breakable          = $int->get('breakable') ? 'true' : 'false';
        $crossable          = $int->get('crossable') ? 'true' : 'false';
        $crossable_active   = $int->get('crossable_active') ? 'true' : 'false';
        $sprite_start_id    = $spr_start->get('id');
        $sprite_start_name  = $spr_start->get('name');
        $sprite_start_url   = $spr_start->getUrl();
        $sprite_active_id   = $spr_active->get('id');
        $sprite_active_name = $spr_active->get('name');
        $sprite_active_url  = $spr_active->getUrl();
        $drops              = $int->get('drops');
        $quantity           = $int->get('quantity');
        $active_time        = $int->get('active_time');
      }
      else{
        $status = 'error';
      }
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',             $status);
    $t->add('id',                 $id);
    $t->add('name',               $name);
    $t->add('type',               $type);
    $t->add('activable',          $activable);
    $t->add('pickable',           $pickable);
    $t->add('grabbable',          $grabbable);
    $t->add('breakable',          $breakable);
    $t->add('crossable',          $crossable);
    $t->add('crossable_active',   $crossable_active);
    $t->add('sprite_start_id',    $sprite_start_id);
    $t->add('sprite_start_name',  $sprite_start_name);
    $t->add('sprite_start_url',   $sprite_start_url);
    $t->add('sprite_active_id',   $sprite_active_id);
    $t->add('sprite_active_name', $sprite_active_name);
    $t->add('sprite_active_url',  $sprite_active_url);
    $t->add('drops',              $drops);
    $t->add('quantity',           $quantity);
    $t->add('active_time',        $active_time);
    $t->process();
  }

  /*
   * Función para guardar un elemento interactivo
   */
  function executeSaveInteractive($req, $t){
    global $c, $s;

    $status           = 'ok';
    $id               = Base::getParam('id',               $req['url_params'], false);
    $name             = Base::getParam('name',             $req['url_params'], false);
    $type             = Base::getParam('type',             $req['url_params'], false);
    $activable        = Base::getParam('activable',        $req['url_params'], false);
    $pickable         = Base::getParam('pickable',         $req['url_params'], false);
    $grabbable        = Base::getParam('grabbable',        $req['url_params'], false);
    $breakable        = Base::getParam('breakable',        $req['url_params'], false);
    $crossable        = Base::getParam('crossable',        $req['url_params'], false);
    $crossable_active = Base::getParam('crossable_active', $req['url_params'], false);
    $drops            = Base::getParam('drops',            $req['url_params'], false);
    $quantity         = Base::getParam('quantity',         $req['url_params'], false);
    $active_time      = Base::getParam('active_time',      $req['url_params'], false);
    $sprite_start_id  = Base::getParam('sprite_start_id',  $req['url_params'], false);
    $sprite_active_id = Base::getParam('sprite_active_id', $req['url_params'], false);

    $url    = '';
    $is_new = 'true';

    if ($id===false || $name===false || $type===false || $drops===false || $quantity===false || $active_time===false || $sprite_start_id===false || $sprite_active_id===false){
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
      $int->set('name',             $name);
      $int->set('type',             $type);
      $int->set('activable',        ($activable=='true'));
      $int->set('pickable',         ($pickable=='true'));
      $int->set('grabbable',        ($grabbable=='true'));
      $int->set('breakable',        ($breakable=='true'));
      $int->set('crossable',        ($crossable=='true'));
      $int->set('crossable_active', ($crossable_active=='true'));
      $int->set('drops',            $drops);
      $int->set('quantity',         $quantity);
      $int->set('active_time',      $active_time);
      $int->set('sprite_start',     $sprite_start_id);
      $int->set('sprite_active',    $sprite_active_id);

      $int->save();

      $id  = $int->get('id');
      $url = $int->getSpriteStart()->getUrl();
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status', $status);
    $t->add('is_new', $is_new);
    $t->add('id',     $id);
    $t->add('name',   $name);
    $t->add('url',    $url);
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