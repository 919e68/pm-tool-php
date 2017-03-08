<?php
class CommentsController extends AppController {

  public $uses = ['TaskComment'];
  public $components = ['RequestHandler'];

  public function beforeFilter() {
      parent::beforeFilter();
      $this->RequestHandler->ext = 'json';
  }


  public function add() {
    $res = ['ok'  => false];
    $err = [];

    // validation
    $input = $this->request->data;
    if (!isPresent($input, 'task_id')) {
      $err['task_id'] = 'task id is required';

    } 

    if (!isPresent($input, 'member_id')) {
      $err['member_id'] = 'member id is required';

    }

    if (!isPresent($input, 'comment')) {
      $err['comment'] = 'comment is required';

    }

    // response
    if (count($err) > 0) {
      $res['errors'] = $err;

    } else {
      $this->TaskComment->create();
      $this->TaskComment->save($this->request->data);

      $id = $this->TaskComment->getLastInsertId();
      $data = $this->TaskComment->find('first', ['conditions' => ['TaskComment.id' => $id]])['TaskComment'];

      $res['ok']   = true;
      $res['data'] = $data;
    }

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }
  
  public function edit($id = null) {
    $res = ['ok'  => false];
    $err = [];

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }
  
  public function delete($id = null) {
    $res = ['ok' => false];

    if ($this->Task->hasAny(['Task.id' => $id])) {
      $data = $this->Task->find('first', ['conditions' => ['Task.id' => $id]])['Task'];

      $this->Task->delete($id);
      $this->Task->TaskComment->deleteAll(['TaskComment.task_id' => $id]);
      $this->Task->TaskMember->deleteAll(['TaskMember.task_id'   => $id]);

      $res['ok']   = true;
      $res['data'] = $data;
    }

    $this->set([
      'res'        => $res,
      '_serialize' => 'res'
    ]);
  }


  public function api_comments($id) {

    // query
    $options['contain'] = [
      'Member' => [
        'fields' => ['Member.id', 'Member.first_name', 'Member.last_name']
      ]
    ];
    $options['conditions']['TaskComment.task_id'] = $id; 
    $datas = $this->Task->TaskComment->find('all', $options);

    // format result
    $comments = [];
    foreach ($datas as $data) {
      $comment = [
        'id'       => $data['TaskComment']['id'],
        'comment'  => $data['TaskComment']['comment'],
        'created'  => $data['TaskComment']['created'],
        'modified' => $data['TaskComment']['modified'],
        'member' => [
          'first_name' => $data['Member']['first_name'],
          'last_name'  => $data['Member']['last_name'],
        ]
      ];


      $comments[] = $comment;
    }

    $res = [
      'ok'   => true,
      'msg'  => 'comments'
    ];

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }
  
  
}