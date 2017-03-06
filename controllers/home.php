<?php
  /*
   * Página temporal, sitio cerrado
   */
  function executeClosed($req, $t){
    $t->process();
  }
  
  /*
   * Pantalla de inicio
   */
  function executeIndex($req, $t){
    $t->addCss('home');
    $t->addJs('home');
    $t->process();
  }
  
  /*
   * Página para elegir partida
   */
  function executePlayerSelect($req, $t){
    global $s;

    $games = stPublic::getGames($s->getParam('id'));
    $t->addPartial('games', 'public/games', array('games'=>$games));
    
    $t->addCss('player-select');
    $t->addJs('player-select');
    $t->process();
  }

  /*
   * Pantalla de juego
   */
  function executeGame($req, $t){
    $scn = new Scenario();
    $scn->find(array('id'=>1));
    $backgrounds = stPublic::getBackgrounds();
    $sprites     = stPublic::getSprites();
    
    $t->add('scn_data', $scn->get('data'));
    $t->add('bcks_data', json_encode(stPublic::getBackgroundsData($backgrounds)));
    $t->add('sprs_data', json_encode(stPublic::getSpritesData($sprites)));
    
    $t->addJs('player');
    $t->addJs('game');
    $t->addCss('game');
    $t->addCss('sprites');
    $t->process();
  }
  
  /*
   * Página para editar escenarios
   */
  function executeEdit($req, $t){
    $scenarios = stPublic::getScenarios();
    
    $t->addJs('edit');
    $t->addCss('edit');
    $t->addPartial('scenarios', 'edit/scenarios', array('scenarios'=>$scenarios));
    $t->process();
  }
  
  /*
   * Página para editar un escenario
   */
  function executeEditScenario($req, $t){
    $scn = new Scenario();
    $scn->find(array('id'=>$req['id']));
    
    $backgrounds = stPublic::getBackgrounds();
    $sprites     = stPublic::getSprites();
    
    $t->add('scn_id',   $scn->get('id'));
    $t->add('scn_name', $scn->get('name'));
    $t->add('scn_data', $scn->get('data'));
    $t->addPartial('backgrounds', 'edit/backgrounds', array('backgrounds'=>$backgrounds));
    $t->add('bcks_data', json_encode(stPublic::getBackgroundsData($backgrounds)));
    $t->addPartial('sprites', 'edit/sprites', array('sprites'=>$sprites));
    $t->add('sprs_data', json_encode(stPublic::getSpritesData($sprites)));

    $t->setTitle('Game - '.$scn->get('name'));
    $t->addJs('edit');
    $t->addCss('edit');
    $t->addCss('game');
    $t->addCss('sprites');
    $t->process();
  }