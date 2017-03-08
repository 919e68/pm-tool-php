<?php
class MainController extends AppController {

  public $uses = ['User'];
  public $components = ['RequestHandler'];

  public function beforeFilter() {
    $this->Auth->allow('index', 'login', 'logout', 'auth', 'test', 'query');
  }

  public function apiWelcome() {
    $this->autoRender = false;
    $this->RequestHandler->respondAs('json');

    echo json_encode([
      'ok'  => true,
      'msg' => 'Welcome to PM Tool API'
    ]);
  }

	public function index() {

	}

  public function projects() {

  }

  public function login() {
    $this->layout = 'login';

    if ($this->Auth->loggedIn()) {
      return $this->redirect([
        'controller' => 'main',
        'action'     => 'index'
      ]);
    }
  }

  public function logout() {
    return $this->redirect($this->Auth->logout());
  }

  public function auth() {
    $this->autoRender = false;
    $this->RequestHandler->respondAs('json');

    if ($this->Auth->loggedIn()) {
      return $this->redirect([
        'controller' => 'main',
        'action'     => 'index'
      ]);
    }

    echo json_encode([
      'ok'  => false,
      'msg' => 'authentication failed'
    ]);
  }

  public function test() {
    $this->autoRender = false;
    $this->RequestHandler->respondAs('json');

    ($this->request->data);

    $res = [
      'isLoggedIn' => $this->Auth->loggedIn()
    ];

    echo json_encode($res);
  }
}


















