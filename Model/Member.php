<?php
class Member extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $belongsTo = [
    'User',
    'ProjectMember',
    'Attachment' => [
      'foreignKey' => 'image_id'
    ]
  ];

  public $hasMany = [
    'TaskMember', 
    'TaskComment'
  ];

  public function projectList($id) {
    $datas = $this->ProjectMember->find('all', [
      'contain'    => [
        'Project' => [
          'fields' => ['Project.id', 'Project.name']
        ]
      ],
      'conditions' => ['ProjectMember.member_id' => $id]
    ]);

    $projects = [];
    foreach ($datas as $data) {
      $project = [
        'id'   => $data['Project']['id'],
        'name' => $data['Project']['name']
      ];

      $projects[] = $project;
    }

    return $projects;
  }

}
