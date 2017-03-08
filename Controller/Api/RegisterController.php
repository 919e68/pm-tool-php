<?php
class RegisterController extends AppController {

  public $uses = ['User'];
  public $components = ['Paginator', 'RequestHandler'];

  public function beforeFilter() {
    $this->RequestHandler->ext = 'json';
    $this->Auth->allow('add');
  }

  public function add() {
    $res = ['ok'  => false];
    $err = [];

    // validation
    $input = $this->request->data;

    if (!isPresent($input, 'username')) {
      $err['username'] = 'username is required';

    } elseif ($this->User->hasAny(['User.username' => $input['username']])) {
      $err['username'] = 'username is already registered';

    }

    if (!isPresent($input, 'first_name')) {
      $err['first_name'] = 'first name is required';

    }

    if (!isPresent($input, 'last_name')) {
      $err['last_name'] = 'last name is required';

    }

    if (!isPresent($input, 'email')) {
      $err['email'] = 'email is required.';

    } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
      $err['email'] = 'invalid email';

    } elseif ($this->User->hasAny(['User.email' => $input['email']])) {
      $err['email'] = 'email is already registered';

    }

    if (!isPresent($input, 'password')) {
      $err['password'] = 'password is required';

    }  elseif (strlen($input['password']) < 8) {
      $err['password'] = 'password must be atleast 8 characters';

    }

    $res['test'] = isPresent($input, 'username');

    // response
    if (count($err) > 0) {
      $res['errors'] = $err;

    } else {
      $inputData = [
        'User' => [
          'username' => $input['username'],
          'email'    => $input['email'],
          'password' => $input['password']
        ],
        'Member' => [
          'first_name' => $input['first_name'],
          'last_name'  => $input['last_name']
        ]
      ];

      $this->User->saveAssociated($inputData);
      $id = $this->User->getLastInsertId();
      $data = $this->User->data($id);

      $res['ok']   = true;
      $res['data'] = $data;

    }

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }
}