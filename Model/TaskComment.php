<?php
class TaskComment extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $belongsTo = ['Task', 'Member'];

}
