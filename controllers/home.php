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
    $t->addJs('game');
    $t->process();
  }
  
  /*
   * Página para editar escenarios
   */
  function executeEdit($req, $t){
    $scenarios = stPublic::getScenarios();
    
    $t->addJs('edit');
    $t->addCss('edit');
    $t->addPartial('scenarios', 'public/scenarios', array('scenarios'=>$scenarios));
    $t->process();
  }