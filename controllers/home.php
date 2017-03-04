<?php
  /*
   * Página temporal, sitio cerrado
   */
  function executeClosed($req, $t){
    $t->process();
  }

  /*
   * Home pública
   */
  function executeIndex($req, $t){
    $scn = new Scenario();
    $scn->find(array('id'=>1));
    $backgrounds = stPublic::getBackgrounds();
    
    $t->add('scn_data', $scn->get('data'));
    $t->add('bcks_data', json_encode(stPublic::getBackgroundsData($backgrounds)));
    
    $t->addJs('game');
    $t->addCss('game');
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
    
    $t->add('scn_id',   $scn->get('id'));
    $t->add('scn_name', $scn->get('name'));
    $t->add('scn_data', $scn->get('data'));
    $t->addPartial('backgrounds', 'edit/backgrounds', array('backgrounds'=>$backgrounds));
    $t->add('bcks_data', json_encode(stPublic::getBackgroundsData($backgrounds)));

    $t->setTitle('Game - '.$scn->get('name'));
    $t->addJs('edit');
    $t->addCss('edit');
    $t->addCss('game');
    $t->process();
  }