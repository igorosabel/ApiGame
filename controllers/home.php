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
    $t->process();
  }

  /*
   * Pantalla de juego
   */
  function executeGame($req, $t){
    $id_game = $req['id'];

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