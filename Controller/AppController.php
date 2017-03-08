<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	
  public $components = [
    'Auth' => [
      'loginAction' => [
        'controller' => 'main',
        'action'     => 'auth'
      ],
      'logoutRedirect' => [
        'controller' => 'main',
        'action'     => 'index'
      ],
      'authenticate' => [
        'Form' => [
          'scope' => [
            'User.verified' => true
          ]
        ],
      ]
    ], 
    'Session',
    'Cookie'
  ];

  // public $components = array(
  // 	'Global',
  // 	'Paginator',
  //     'Session', 'Cookie',
  //     'Auth' => array(
  //       'loginRedirect' => array(
  //           'controller' => 'main',
  //           'action' => 'index'
  //       ),
  //       'loginAction' => array(
  //           'controller' => 'main',
  //           'action' => 'login'
  //       ),
//         'logoutRedirect' => array(
//             'controller' => 'main',
//             'action' => 'login'
//         ),
  //       'authenticate' => array(
  //           'Form' => array(
  //               'scope' => array('User.verified'=>true, 'User.visible'=>true)
  //           ),
  //       )
  //     )
  // );
    

  
}
