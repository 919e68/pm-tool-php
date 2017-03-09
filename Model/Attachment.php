<?php
class Attachment extends AppModel {

  public $recursive = -1;
  public $actsAs = ['Containable'];

  public $hasOne = [
    'Member'
  ];

  public function upload($files, $id = null) {
    $result = $id;

    if (count($files) > 0) {
      $file = $files['image'];
      
      if (!empty($file['name'])) {

        $attachment = ['filename' => $file['name']];
        if (!empty($id)) {
          $oldAttachment = $this->find('first', [
            'conditions' => ['Attachment.id' => $id]
          ]);

          if (!empty($oldAttachment)) {
            unlink("uploads/attachments/$id/" . $oldAttachment['Attachment']['filename']);
          }
          
          $attachment['id'] = $id;
        }

        $this->save($attachment);

        if (empty($id)) $id = $this->getLastInsertId();
        $imagePath = "uploads/attachments/$id";

        if(!file_exists($imagePath)) mkdirr($imagePath);
        move_uploaded_file($file['tmp_name'], $imagePath . '/' . $file['name']);

        $result = $id;
      }
    }

    return $result;
  }
}
