<?php
class MembersController extends AppController {

  public $uses = ['Member'];
  public $components = ['Paginator', 'RequestHandler', 'Thumbnail'];

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
      'ok'  => false
    ];

    $member = $this->Member->find('first', [
      'conditions' => [
        'Member.id' => $id
      ],
      'contain' => ['Attachment']
    ]);

    if ($this->request->is('post') and !empty($member)) {
      $this->request->data['id'] = $id;

      $this->request->data['image_id'] = $this->Member->Attachment->upload($_FILES, $member['Attachment']['id']);
      $this->Member->save($this->request->data);

      $member = $this->Member->find('first', [
        'conditions' => [
          'Member.id' => $id
        ],
        'contain' => ['Attachment']
      ]);

      $avatar = $this->Thumbnail->render('/uploads/attachments/' . $member['Attachment']['id'] . '/' . $member['Attachment']['filename'], [
        'width'   => 128, 
        'height'  => 128, 
        'quality' => 100,
        'resize'  => 'crop', 
        'cachePath' => 'attachments/' . $member['Attachment']['id']
      ]);

      $res['data'] = [
        'id'         => $member['Member']['id'],
        'user_id'    => $member['Member']['user_id'],
        'first_name' => $member['Member']['first_name'],
        'last_name'  => $member['Member']['last_name'],
        'avatar'     => serverUrl() . $this->base . '/' . $avatar
      ];


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