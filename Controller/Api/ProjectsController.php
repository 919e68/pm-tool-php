<?php
class ProjectsController extends AppController {

  public $uses = ['Project'];
  public $components = ['RequestHandler'];

  public function beforeFilter() {
    parent::beforeFilter();
    $this->RequestHandler->ext = 'json';
  }

  public function index() {
    // query
    $query = $this->request->query;

    $options['fields'] = ['Project.id', 'Project.name', 'Project.description'];
    $options['limit'] = isset($query['limit']) ? $query['limit'] : 15;

    if (isset($query['above'])) {
      if (is_numeric($query['above'])) {
        $options['conditions'] = ['Project.id >' => $query['above']];
      }
    }

    $options['order'] = ['Project.id'];
    $datas = $this->Project->find('all', $options);

    // pagination
    $pagination = ['remaining' => 0, 'total' => 0, 'pages' => 0];
    $pagination['total'] = $this->Project->find('count');
    $pagination['pages'] = ceil($pagination['total'] / $options['limit']);
    if (count($datas) > 0) {
      $pagination['remaining'] = $this->Project->remaining(end($datas)['Project']['id']);
      $pagination['continue']  = $pagination['remaining'] > 0 ? true : false;
    }
    

    // format result
    $projects = [];

    foreach ($datas as $data) {
      $projects[] = $data['Project'];
    }

    // response
    $res = [
      'ok'         => true,
      'data'       => $projects,
      'pagination' => $pagination
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
    $ok = false;
    $res = ['ok' => false];
    $err = [];
    $data = null;

    // validation
    $input = $this->request->data;
    if (!isPresent($input, 'name')) {
      $err['name'] = 'project name is required';

    }

    // response
    if (count($err) > 0) {
      $res['errors'] = $err;

    } else {
      $this->Project->create();
      $this->Project->save($this->request->data);

      $id = $this->Project->getLastInsertId();
      $data = $this->Project->find('first', ['conditions' => ['Project.id' => $id]])['Project'];

      $res['ok']   = true;
      $res['data'] = $data;
    }

    $this->set(array(
      'res'        => $res,
      '_serialize' => 'res'
    ));

  }
  
  public function edit($id = null) {
    $res = ['ok' => false];

    if ($this->Project->hasAny(['Project.id' => $id])) {
      $this->request->data['id'] = $id;
      $this->Project->save($this->request->data);
      
      $data = $this->Project->find('first', ['conditions' => ['Project.id' => $id]])['Project'];

      $res['ok']   = true;
      $res['data'] = $data;
      
    }

    $this->set([
      'res'        => $res,
      '_serialize' => 'res'
    ]);
  }
  
  public function delete($id = null) {
    $res = ['ok' => false];

    if ($this->Project->hasAny(['Project.id' => $id])) {
      $data = $this->Project->find('first', ['conditions' => ['Project.id' => $id]])['Project'];

      $this->Project->delete($id);
      $this->Project->ProjectMember->deleteAll(['ProjectMember.project_id' => $id]);

      $res['ok']   = true;
      $res['data'] = $data;
    }

    $this->set([
      'res'        => $res,
      '_serialize' => 'res'
    ]);
  }
  
  
}