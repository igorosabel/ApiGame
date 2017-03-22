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
    $game = new Game();
    $game->find(array('id'=>$req['id']));
    $scn = $game->getScenario();
    
    $backgrounds = stPublic::getBackgrounds();
    $sprites     = stPublic::getSprites();

    $t->addPartial('backgrounds_css', 'public/backgrounds_css', array('backgrounds'=>$backgrounds));
    $t->addPartial('sprites_css',     'public/sprites_css',     array('sprites'=>$sprites));
    
    $t->add('scn_data',    $scn->get('data'));
    $t->add('position_x',  $game->get('position_x'));
    $t->add('position_y',  $game->get('position_y'));
    $t->add('player_name', $game->get('name'));
    $t->add('bcks_data', json_encode(stPublic::getBackgroundsData($backgrounds)));
    $t->add('sprs_data', json_encode(stPublic::getSpritesData($sprites)));
    
    $t->addCss('game');
    $t->process();
  }