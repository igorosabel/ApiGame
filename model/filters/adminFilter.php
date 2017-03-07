<?php
  /*
   * Filtro de seguridad para el panel de admin
   */
  function adminFilter($req){
    global $s;
    $req['filter'] = array('status'=>'error', 'data'=>null);
    
    if ($s->getParam('admin')){
      $req['filter']['status'] = 'ok';
    }
    
    return $req;
  }