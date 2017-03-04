<?php
  /*
   * Función para añadir un nuevo escenario
   */
  function executeSaveScn($req, $t){
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
      for ($i=0;$i<17;$i++){
        $row = array();
        for ($j=0;$j<17;$j++){
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