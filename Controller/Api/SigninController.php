<?php
class SigninController extends AppController {

  public $uses = ['User'];
  public $components = ['RequestHandler'];

  public function beforeFilter() {
    $this->RequestHandler->ext = 'json';
    $this->Auth->allow('add');
  }

  public function add() {
    $res = ['ok' => false];
    $err = [];

    $input = $this->request->data;
    
    if (!isPresent($input, 'username')) {
      $err['username'] = 'username is required';
    }

    if (!isPresent($input, 'password')) {
      $err['password'] = 'password is required';
    }

    if (count($err) > 0) {
      $res['errors'] = $err;

    } else {

      $user = $this->User->authenticate($input['username'], $input['password']);
      if (!empty($user)) {
        unset($user['User']['password']);
        $this->Session->Write('Auth', $user);
        $this->User->generateToken($input['username']);

        $res['ok'] = true;
        $res['user'] = $user;

      } else {
        $res['errors']['incorrect'] = 'incorrect username/password';

      }
    }

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }

}