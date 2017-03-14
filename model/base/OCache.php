<?php
class OCache{
  private $route = null;
  private $debug_mode = false;
  private $log        = null;

  function __construct() {
    global $c, $where;
    $this->setRoute($c->getDir('cache'));
    $this->setDebugMode($c->getDebugMode());
    $l = new OLog();
    $this->setLog($l);
    $this->getLog()->setSection($where);
    $this->getLog()->setModel('OCache');
  }

  public function setRoute($r){
    $this->route = $r;
  }

  public function getRoute(){
    return $this->route;
  }

  public function setDebugMode($dm){
    $this->debug_mode = $dm;
  }

  public function getDebugMode(){
    return $this->debug_mode;
  }

  public function setLog($l){
    $this->log = $l;
  }

  public function getLog(){
    return $this->log;
  }
  
  public function delete($file){
    $route = $this->getRoute().$file.'.json';
    if ($this->getDebugMode()){
      $this->getLog()->put('Cache file "'.$file.'" deleted');
    }
    if (file_exists($route)){
      unlink($route);
    }
  }

  public function get($file){
    $route = $this->getRoute().$file.'.json';
    if ($this->getDebugMode()){
      $this->getLog()->put('Cache file "'.$file.'" requested');
    }
    if (!file_exists($route)){
      return false;
    }
    $data = json_decode(file_get_contents($route),true);
    if (!$data){
      $this->delete($file);
      return false;
    }
    if ( (time()-$data['time'])>(7*24*60*60) ){ // Cache outdated
      $this->delete($file);
      return false;
    }
    return $data;
  }

  public function set($file, $content){
    $data = array(
      'time' => time(),
      'data' => $content
    );
    $route = $this->getRoute().$file.'.json';
    if ($this->getDebugMode()){
      $this->getLog()->put('New cache file "'.$file.'""');
    }
    if (file_exists($route)){
      unlink($route);
    }
    file_put_contents($route, json_encode($data));
  }
}