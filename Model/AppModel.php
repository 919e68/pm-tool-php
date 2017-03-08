<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class AppModel extends Model {
	public $actAs = ['Containable'];

  public function remaining($id, $sorting = 'ASC') {
    if ($sorting == 'ASC') {
      $operator = '>';
    } else {
      $operator = '<';
    }

    $count = $this->find('count', ['conditions' => ["id $operator" => $id]]);
    return $count;
  }
}
