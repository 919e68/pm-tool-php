<?php
class Project extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $belongsTo = [
    'ProjectMember'
  ];

}
