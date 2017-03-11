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
        $game->set('name', $name);
        $game->set('id_scenario', 1);
        $game->set('position_x', 14);
        $game->set('position_y', 13);
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
    
    if ($id===false || $name===false || $scenario===false){
      $status = 'error';
    }
    
    if ($status=='ok'){
      $scn = new Scenario();
      if ($scn->find(array('id'=>$id))){
        $scn->set('name', urldecode($name));
        $scn->set('data', $scenario);
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
    $crossable   = Base::getParam('crossable',   $req['url_params'], false);
    $is_new      = 'true';

    if ($name===false || $class===false || $crossable===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $id    = (int)$id;
      $name  = urldecode($name);
      $class = urldecode($class);

      $bck = new Background();
      if ($id!==0){
        $bck->find(array('id'=>$id));
        $is_new = 'false';
      }
      $bck->set('id_category', $id_category);
      $bck->set('name',        $name);
      $bck->set('class',       $class);
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