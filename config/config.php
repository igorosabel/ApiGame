<?php
  /* Datos generales */
  date_default_timezone_set('Europe/Madrid');

  $basedir = realpath(dirname(__FILE__));
  $basedir = str_ireplace('config','',$basedir);

  require($basedir.'model/base/OConfig.php');
  $c = new OConfig();
  $c->setBaseDir($basedir);

  /* Carga de módulos */
  $c->loadDefaultModules();

  /* Carga de paquetes */
  $c->loadPackages();

  /* Datos de la Base De Datos */
  $c->setDB('host','localhost');
  $c->setDB('user','game');
  $c->setDB('pass','384Q#mrb');
  $c->setDB('name','game');

  /* Datos para cookies */
  $c->setCookiePrefix('game');
  $c->setCookieUrl('.osumi.es');
  
  /* Activa/desactiva el modo debug que guarda en log las consultas SQL e información variada */
  $c->setDebugMode(false);

  /* URL del sitio */
  $c->setBaseUrl('https://game.osumi.es/');
  
  /* Email del administrador al que se notificarán varios eventos */
  $c->setAdminEmail('inigo.gorosabel@gmail.com');
  
  /* Lista de CSS por defecto */
  $c->setCssList( array('game') );
  
  /* Lista de JavaScript por defecto */
  $c->setJsList( array('common') );
  
  /* Título de la página */
  $c->setDefaultTitle('Game');

  /* Idioma de la página */
  $c->setLang('es');
  
  /* Para cerrar la página descomentar la siguiente linea */
  //$c->setPaginaCerrada(true);
  
  /* Páginas de error customizadas */
  // $c->setErrorPage('403','/admin');
  
  /* Anchura y altura del escenario, en casillas */
  $c->setExtra('width', 24);
  $c->setExtra('height', 18);