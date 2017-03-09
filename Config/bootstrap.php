<?php
Cache::config('default', array('engine' => 'File'));

App::build(array(
  'Controller' => array(
    ROOT . DS . APP_DIR . DS . 'Controller' . DS . 'Api' . DS
  )
));

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));

CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

function isPresent($data, $index = '') {
  $result = false;

  if(is_array($data))   {
    if (array_key_exists($index, $data)) {
      if (!empty($data[$index])) {
        $result = true;
      }
    }
  } else {
    if (!empty($data[$index])) {
      $result = true;
    }
  }

  return $result;
}

function mkdirr($path) {
  $folders = explode('/', $path);
  $folderPath = '';

  foreach ($folders as $key => $folder) {
    $delimeter = $key > 0? '/' : '';
    $folderPath .= $delimeter . $folder;

    if(!file_exists($folderPath)) {
      mkdir($folderPath);
    }
  }
}
