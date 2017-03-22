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
    $class       = Base::getParam('class',       $req['url_params'], false);
    $css         = Base::getParam('css',       $req['url_params'], false);
    $crossable   = Base::getParam('crossable',   $req['url_params'], false);
    $is_new      = 'true';

    if ($name===false || $class===false || $css===false || $crossable===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $id    = (int)$id;
      $name  = urldecode($name);
      $class = urldecode($class);
      $css   = urldecode($css);

      $bck = new Background();
      if ($id!==0){
        $bck->find(array('id'=>$id));
        $is_new = 'false';
      }
      $bck->set('id_category', $id_category);
      $bck->set('name',        $name);
      $bck->set('class',       $class);
      $bck->set('css',         $css);
      $bck->set('crossable',   ($crossable=='true'));
      $bck->save();

      $id = $bck->get('id');
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',      $status);
    $t->add('id',          $id);
    $t->add('id_category', $id_category);
    $t->add('name',        $name);
    $t->add('class',       $class);
    $t->add('css',         $css);
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
   * Función para guardar un fondo
   */
  function executeSaveSprite($req, $t){
    $status      = 'ok';
    $id          = Base::getParam('id',          $req['url_params'], false);
    $id_category = Base::getParam('id_category', $req['url_params'], false);
    $name        = Base::getParam('name',        $req['url_params'], false);
    $class       = Base::getParam('class',       $req['url_params'], false);
    $css         = Base::getParam('css',         $req['url_params'], false);
    $crossable   = Base::getParam('crossable',   $req['url_params'], false);
    $breakable   = Base::getParam('breakable',   $req['url_params'], false);
    $grabbable   = Base::getParam('grabbable',   $req['url_params'], false);
    $pickable    = Base::getParam('pickable',    $req['url_params'], false);
    $is_new      = 'true';

    if ($name===false || $class===false || $css===false || $crossable===false || $grabbable===false || $pickable===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $id    = (int)$id;
      $name  = urldecode($name);
      $class = urldecode($class);
      $css   = urldecode($css);

      $spr = new Sprite();
      if ($id!==0){
        $spr->find(array('id'=>$id));
        $is_new = 'false';
      }
      $spr->set('id_category', $id_category);
      $spr->set('name',        $name);
      $spr->set('class',       $class);
      $spr->set('css',         $css);
      $spr->set('crossable',   ($crossable=='true'));
      $spr->set('breakable',   ($breakable=='true'));
      $spr->set('grabbable',   ($grabbable=='true'));
      $spr->set('pickable',    ($pickable=='true'));
      $spr->save();

      $id = $spr->get('id');
    }

    $t->setLayout(false);
    $t->setJson(true);

    $t->add('status',      $status);
    $t->add('id',          $id);
    $t->add('id_category', $id_category);
    $t->add('name',        $name);
    $t->add('class',       $class);
    $t->add('css',         $css);
    $t->add('crossable',   $crossable);
    $t->add('breakable',   $breakable);
    $t->add('grabbable',   $grabbable);
    $t->add('pickable',    $pickable);
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