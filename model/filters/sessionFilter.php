<?php
  /*
   * Filtro de seguridad para validar el usuario
   */
  function sessionFilter($req){
    global $s;
    $req['filter'] = array('status'=>'error', 'data'=>null);
    
    if ($s->getParam('logged')){      
      $req['filter']['status'] = 'ok';
      $req['filter']['id'] = $s->getParam('id');
      $req['filter']['name'] = $s->getParam('name');
    }
    
    return $req;
  }