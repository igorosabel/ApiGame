<?php
  /*
   * Página para editar escenarios
   */
  function executeScenarios($req, $t){
    $scenarios = stAdmin::getScenarios();

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