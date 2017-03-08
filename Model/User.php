<?php
class User extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $hasOne = ['Member'];

  public function beforeSave($options = []) {
    if (isset($this->data[$this->alias]['password'])) {
      $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
    return true;
  }

  public function authenticate($username, $password) {
    $user = $this->find('first', [
      'conditions' => [
        'OR' => [
          'User.username' => $username,
          'User.email'    => $username
        ],
        'User.password' => AuthComponent::password($password)
        
      ]
    ]);

    return $user;
  }

  public function data($id) {
    $user = null;
    
    if ($this->hasAny(['User.id' => $id])) {
      $data = $this->find('first', [
        'contain' => [
          'Member' => [
            'fields' => ['Member.id', 'Member.first_name', 'Member.last_name']
          ]
        ],
        'conditions' => [
          'User.id' => $id
        ],
        'fields' => ['User.id', 'User.username', 'User.email']
      ]);

      $user = [
        'id'         => $data['User']['id'],
        'member_id'  => $data['Member']['id'],
        'username'   => $data['User']['username'],
        'email'      => $data['User']['email'],
        'first_name' => $data['Member']['first_name'],
        'last_name'  => $data['Member']['last_name']
      ];
    }

    return $user;
  }

  public function generateToken($username) {
    $token = strval(bin2hex(openssl_random_pseudo_bytes(16)));

    while($this->hasAny(['User.token' => $token])) {
      $token = strval(bin2hex(openssl_random_pseudo_bytes(16)));
    }

    $date = date('Y-m-d H:i:s', strtotime('+1 day'));

    $this->updateAll([
      'token'            => "'$token'",
      'token_expiration' => "'$date'"
    ], [
      'username' => $username
    ]);

    return $token;
  }
}
