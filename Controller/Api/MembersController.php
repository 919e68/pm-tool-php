<?php
class MembersController extends AppController {

  public $uses = ['Member'];
  public $components = ['Paginator', 'RequestHandler'];

  public function beforeFilter() {
    $this->RequestHandler->ext = 'json';
  }
  
  public function index() {
    $members = [];

    $datas = $this->Member->find('all', [
      'contain' => [
        'User'
      ]
    ]);

    foreach ($datas as $data) {
      $member   = [];
      $projects = $this->Member->projectList($data['Member']['id']);

      $member = [
        'id'              => $data['Member']['id'],
        'user_id'         => $data['Member']['user_id'],
        'username'        => $data['User']['username'],
        'first_name'      => $data['Member']['first_name'],
        'last_name'       => $data['Member']['last_name'],
        'contact_number'  => $data['Member']['contact_number'],
        'email'           => $data['User']['email'],
        'projects'        => $projects
      ];
      
      $members[] = $member;
    }

    $res = [
      'ok'   => true,
      'data' => $members
    ];

    $this->set([
      'res'        => $res,
      '_serialize' => 'res'
    ]);
  }
  
  public function view($id = null) {
    $res = [
      'ok'  => true,
      'msg' => 'view'
    ];

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }
  
  public function add() {
    $res = [
      'ok'  => true,
      'msg' => 'add'
    ];

    if ($this->request->is('post')) {

    }

    $this->set([
      'res'        => $res,
      '_serialize' => 'res'
    ]);
  }


  public function edit($id = null) {
    $res = [
      'ok'  => true,
      'msg' => 'edit'
    ];

    if ($this->request->is('post')) {
      $res['uploaded'] = $this->Member->Attachment->upload($_FILES);
    }

    $this->set([
      'res'        => $res,
      '_serialize' => 'res'
    ]);
  }
  
  public function delete() {
    $res = [
      'ok'  => true,
      'msg' => 'msg'
    ];

    $this->set([
      'response'   => $res,
      '_serialize' => 'res'
    ]);
  }
  
  
}