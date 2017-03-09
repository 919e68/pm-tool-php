<?php
class MainController extends AppController {

  public $uses = ['User', 'Member'];
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

    $response = [
      'ok' => false,
      'msg' => null,
    ];

    $ok = false;
    $msg = null;

    if ($this->Auth->loggedIn()) {
      $response['ok'] = true;
      $response['msg'] = 'user is currently logged in';

      $userId = $this->Session->read('Auth.User.id');

      $data = $this->Member->find('first', [
        'conditions' => [
          'Member.user_id' => $userId
        ],
        'contain' => ['Attachment']
      ]);

      $member = [
        'user_id'    => (int) $userId,
        'member_id'  => (int) $data['Member']['id'],
        'email'      => $this->Session->read('Auth.User.email'),
        'first_name' => $data['Member']['first_name'],
        'last_name'  => $data['Member']['last_name'],
        'contact_number' => $data['Member']['contact_number'],
        'city'    => $data['Member']['city'],
        'country' => $data['Member']['country']
      ];

      $response['data'] = $member;
      $response['data'] = $data;

    } else {
      $response['ok'] = false;
      $response['msg'] = 'authentication failed';
    }

    echo json_encode($response);
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


















