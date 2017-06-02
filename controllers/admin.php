<?php
  /*
   * Inicio de sesión en panel admin
   */
  function executeAdmin($req, $t){
    global $s;

    $msg = '';
    if ($s->getParam('admin_error')){
      $msg = 'El nombre de usuario o contraseña no son correctos.';
      $s->removeParam('admin_error');
    }

    $t->add('msg', $msg);
    $t->addCss('home');
    $t->process();
  }

  /*
   * Función para iniciar sesión en el panel admin
   */
  function executeLogin($req, $t){
    global $c, $s;
    $status = 'ok';
    $user = Base::getParam('user', $req['url_params'], false);
    $pass = Base::getParam('pass', $req['url_params'], false);

    if ($user===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      if ($user=='admin' && $pass==$c->getExtra('admin_pass')){
        $status = 'ok';
      }
      else{
        $status = 'error';
      }
    }

    if ($status=='ok'){
      $s->addParam('admin', true);
      header('Location:'.OUrl::generateUrl('adminMain'));
    }
    else{
      $s->addParam('admin_error',true);
      header('Location:'.OUrl::generateUrl('admin'));
    }
  }

  /*
   * Página inicial en el panel admin
   */
  function executeMain($req, $t){
    $t->addCss('admin');
    $t->process();
  }

  /*
   * Página para editar escenarios
   */
  function executeScenarios($req, $t){
    $scenarios = stAdmin::getScenarios();

    $t->addCss('admin');
    $t->addPartial('scenarios', 'admin/scenarios', array('scenarios'=>$scenarios));
    $t->process();
  }

  /*
   * Página para editar un escenario
   */
  function executeEditScenario($req, $t){
    $scn = new Scenario();
    $scn->find(array('id'=>$req['id']));

    $scenario = array(
      'id' => $scn->get('id'),
      'name' => $scn->get('name'),
      'data' => json_decode($scn->get('data'),true),
      'start_x' => $scn->get('start_x'),
      'start_y' => $scn->get('start_y'),
      'initial' => $scn->get('initial')
    );

    $backgrounds = stPublic::getBackgrounds();
    $sprites     = stPublic::getSprites();

    $t->addPartial('backgrounds_css', 'public/backgrounds_css', array('backgrounds'=>$backgrounds));
    $t->addPartial('sprites_css',     'public/sprites_css',     array('sprites'=>$sprites));
    $t->add('scenario', json_encode($scenario));
    $t->addPartial('backgrounds', 'admin/backgrounds', array('backgrounds'=>$backgrounds));
    $t->add('bcks_data', json_encode(stPublic::getBackgroundsData($backgrounds)));
    $t->addPartial('sprites', 'admin/sprites', array('sprites'=>$sprites));
    $t->add('sprs_data', json_encode(stPublic::getSpritesData($sprites)));

    $t->setTitle('Game - '.$scn->get('name'));
    $t->addCss('admin');
    $t->addCss('game');
    $t->process();
  }
  
  /*
   * Página para editar los fondos
   */
  function executeBackgrounds($req, $t){
    $backgrounds = stPublic::getBackgrounds();

    $t->addCss('admin');
    $t->addCss('game');
    $t->addPartial('backgrounds_css', 'public/backgrounds_css', array('backgrounds'=>$backgrounds));
    $t->addPartial('backgrounds',     'admin/backgrounds_edit', array('backgrounds'=>$backgrounds));
    $t->process();
  }
  
  /*
   * Página para editar los sprites
   */
  function executeSprites($req, $t){
    $sprites = stPublic::getSprites();

    $t->addCss('admin');
    $t->addPartial('sprites_css', 'public/sprites_css', array('sprites'=>$sprites));
    $t->addPartial('sprites',     'admin/sprites_edit', array('sprites'=>$sprites));
    $t->process();
  }
  
  /*
   * Página para editar los elementos interactivos
   */
  function executeInteractives($req, $t){
    $interactives = stPublic::getInteractives();
    $sprites      = stPublic::getSprites();

    $t->addCss('admin');
    $t->addPartial('sprites_css',  'public/sprites_css',      array('sprites'=>$sprites));
    $t->addPartial('interactives', 'admin/interactives_edit', array('interactives'=>$interactives));
    $t->addPartial('sprites',      'admin/sprites',           array('sprites'=>$sprites));
    $t->process();
  }
  
  /*
   * Página para editar los usuarios
   */
  function executeUsers($req, $t){
    $users = stAdmin::getUsers();
    $scenarios = stAdmin::getScenarios();

    $t->addCss('admin');
    $t->addPartial('users',     'admin/users_edit',      array('users'=>$users));
    $t->addPartial('scenarios', 'admin/scenarios_users', array('scenarios'=>$scenarios));
    $t->process();
  }