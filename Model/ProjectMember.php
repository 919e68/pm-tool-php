<?php
class ProjectMember extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $belongsTo = [
    'Project',
    'Member'
  ];

}
