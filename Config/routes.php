<?php

	Router::connect('/', [
		'controller' => 'main', 
		'action'     => 'index'
	]);

  Router::connect('/login', [
    'controller' => 'main', 
    'action'     => 'login'
  ]);

  Router::connect('/logout', [
    'controller' => 'main', 
    'action'     => 'logout'
  ]);

  Router::connect('/auth', [
    'controller' => 'main', 
    'action'     => 'auth'
  ]);

  Router::connect('/api', [
    'controller' => 'main', 
    'action'     => 'apiWelcome'
  ]);

  Router::connect('/projects', [
    'controller' => 'main', 
    'action'     => 'projects'
  ]);

  // for testing only
  Router::connect('/test', [
    'controller' => 'main', 
    'action'     => 'test'
  ]);

  Router::connect('/query', [
    'controller' => 'main', 
    'action'     => 'query'
  ]);
  // 



  $apiRoutes = ['register', 'signin', 'projects', 'members', 'tasks', 'comments'];
  Router::mapResources($apiRoutes, array('prefix' => 'api'));
	Router::parseExtensions('json');
  
	CakePlugin::routes();
	// require CAKE . 'Config' . DS . 'routes.php';
