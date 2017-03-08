<?php
class TasksController extends AppController {

  public $uses = ['Task'];
  public $components = ['RequestHandler'];

  public function beforeFilter() {
      parent::beforeFilter();
      $this->RequestHandler->ext = 'json';
  }

  public function index() {
    $res = [
      'ok'   => true,
      'msg'  => 'index'
    ];

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
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
    $res = ['ok'  => false];
    $err = [];

    // validation
    $input = $this->request->data;
    if (!isPresent($input, 'project_id')) {
      $err['project_id'] = 'project is required';

    } 

    if (!isPresent($input, 'member_id')) {
      $err['member_id'] = 'member is required';

    }

    if (!isPresent($input, 'task')) {
      $err['task'] = 'task name is required';

    }

    // response
    if (count($err) > 0) {
      $res['errors'] = $err;

    } else {
      $this->Task->create();
      $this->Task->save($this->request->data);

      $id = $this->Task->getLastInsertId();
      $data = $this->Task->find('first', ['conditions' => ['Task.id' => $id]])['Task'];

      $res['ok']   = true;
      $res['data'] = $data;
    }

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }
  
  public function edit($id = null) {
    
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
    $res = ['ok' => false];

    // query
    $query = $this->request->query;
    $options['limit'] = isset($query['limit']) ? $query['limit'] : 15;

    if (isset($query['below'])) {
      if (is_numeric($query['below'])) {
        $options['conditions']['TaskComment.id <'] = $query['below'];
      }
    }

    $options['contain'] = [
      'Member' => [
        'fields' => ['Member.id', 'Member.first_name', 'Member.last_name']
      ]
    ];
    $options['conditions']['TaskComment.task_id'] = $id; 
    $options['order'] = ['TaskComment.id' => 'DESC'];

    $datas = $this->Task->TaskComment->find('all', $options);

    // pagination
    $pagination = ['remaining' => 0, 'total' => 0, 'pages' => 0];
    $pagination['total'] = $this->Task->TaskComment->find('count');
    $pagination['pages'] = ceil($pagination['total'] / $options['limit']);
    if (count($datas) > 0) {
      $pagination['remaining'] = $this->Task->TaskComment->remaining(end($datas)['TaskComment']['id'], 'DESC');
      $pagination['continue']  = $pagination['remaining'] > 0 ? true : false;
    }

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

    // response
    $res['ok']   = true;
    $res['data'] = $comments;

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));
  }
  
  
}