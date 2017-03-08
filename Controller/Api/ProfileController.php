<?php
class ProfileController extends AppController {

  public $uses = ['User', 'Member'];
  public $components = ['Paginator', 'RequestHandler'];

  public function beforeFilter() {
    parent::beforeFilter();
    $this->RequestHandler->ext = 'json';
  }
  
  public function index() {

    $userId = $this->Session->read('Auth.User.id');

    $data = $this->Member->find('first', [
      'conditions' => [
        'Member.user_id' => $userId
      ]
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

    $res = [
      'ok'   => true,
      'data'  => $member
    ];

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }

}