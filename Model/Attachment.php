<?php
class Attachment extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $hasOne = [
    'Member'
  ];

  public function upload($files) {
    $result = null;

    if (count($files) > 0) {
      $file = $files['image'];
      
      if (!empty($file['name'])) {
        $this->save([
          'name' => $file['name']
        ]);

        $id = $this->getLastInsertId();
        $imagePath = "uploads/attachments/$id";

        if(!file_exists($imagePath)) mkdirr($imagePath);
        move_uploaded_file($file['tmp_name'], $imagePath . '/' . $file['name']);

        $result = $id;
      }
    }

    return $result;
  }
}
