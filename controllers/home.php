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

  /*
   * Pantalla de juego (con canvas)
   */
  function executeCanvas($req, $t){
    $game = new Game();
    $game->find(array('id'=>$req['id']));
    $scn = $game->getScenario();
    $assets = stPublic::getAssetsData($scn->get('data'));

    $t->addPartial('assets', 'public/canvas_assets', array('assets'=>$assets['assets']));
    
    $res = array(
      'bck' => $assets['bck'],
      'spr' => $assets['spr'],
      'player' => array(
        'player_up'    => array('url'=>'link-up',    'crossable'=>false),
        'player_right' => array('url'=>'link-right', 'crossable'=>false),
        'player_down'  => array('url'=>'link-down',  'crossable'=>false),
        'player_left'  => array('url'=>'link-left',  'crossable'=>false),
        'player_up_walking_1'    => array('url'=>'up-walking-1',    'crossable'=>false),
        'player_up_walking_2'    => array('url'=>'up-walking-2',    'crossable'=>false),
        'player_up_walking_3'    => array('url'=>'up-walking-3',    'crossable'=>false),
        'player_up_walking_4'    => array('url'=>'up-walking-4',    'crossable'=>false),
        'player_up_walking_5'    => array('url'=>'up-walking-5',    'crossable'=>false),
        'player_up_walking_6'    => array('url'=>'up-walking-6',    'crossable'=>false),
        'player_up_walking_7'    => array('url'=>'up-walking-7',    'crossable'=>false),
        'player_right_walking_1' => array('url'=>'right-walking-1', 'crossable'=>false),
        'player_right_walking_2' => array('url'=>'right-walking-2', 'crossable'=>false),
        'player_right_walking_3' => array('url'=>'right-walking-3', 'crossable'=>false),
        'player_right_walking_4' => array('url'=>'right-walking-4', 'crossable'=>false),
        'player_right_walking_5' => array('url'=>'right-walking-5', 'crossable'=>false),
        'player_right_walking_6' => array('url'=>'right-walking-6', 'crossable'=>false),
        'player_right_walking_7' => array('url'=>'right-walking-7', 'crossable'=>false),
        'player_down_walking_1'  => array('url'=>'down-walking-1',  'crossable'=>false),
        'player_down_walking_2'  => array('url'=>'down-walking-2',  'crossable'=>false),
        'player_down_walking_3'  => array('url'=>'down-walking-3',  'crossable'=>false),
        'player_down_walking_4'  => array('url'=>'down-walking-4',  'crossable'=>false),
        'player_down_walking_5'  => array('url'=>'down-walking-5',  'crossable'=>false),
        'player_down_walking_6'  => array('url'=>'down-walking-6',  'crossable'=>false),
        'player_down_walking_7'  => array('url'=>'down-walking-7',  'crossable'=>false),
        'player_left_walking_1'  => array('url'=>'left-walking-1',  'crossable'=>false),
        'player_left_walking_2'  => array('url'=>'left-walking-2',  'crossable'=>false),
        'player_left_walking_3'  => array('url'=>'left-walking-3',  'crossable'=>false),
        'player_left_walking_4'  => array('url'=>'left-walking-4',  'crossable'=>false),
        'player_left_walking_5'  => array('url'=>'left-walking-5',  'crossable'=>false),
        'player_left_walking_6'  => array('url'=>'left-walking-6',  'crossable'=>false),
        'player_left_walking_7'  => array('url'=>'left-walking-7',  'crossable'=>false)
      )
    );

    $t->add('res', json_encode($res));
    $t->add('position_x',  $game->get('position_x'));
    $t->add('position_y',  $game->get('position_y'));

    $t->addCss('game');
    $t->process();
  }