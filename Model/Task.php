<?php
class Task extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $belongsTo = ['Project'];

  public $hasMany = ['TaskMember', 'TaskComment'];

}
