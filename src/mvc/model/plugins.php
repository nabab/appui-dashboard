<?php

use bbn\Str;

/** @var bbn\Mvc\Model $model */
$plugins = $model->getPlugins();
$widgets = [];
$fs = new \bbn\File\System();



foreach ( $plugins as $plugin => $cfg ){
  $done = [];
  $fs->cd($cfg['path'].'src/mvc/public');
  $reals = $fs->scan('./', '.php');
  $files = [];
  foreach ( $reals as $f ){
    if (
      $fs->exists($cfg['path'].'src/mvc/html/'.$f) ||
      $fs->exists($cfg['path'].'src/mvc/html/' . Str::sub($f, 0, -3).'html')
    ){
      if ( basename($f) !== 'index.php' ){
        $new = $cfg['url'].'/' . Str::sub($f, 0, -4);
        $files = array_filter($files, function($a)use($new){
          return Str::pos($a, $new.'/') === false;
        });
        $files[] = $new;
      }
    }
  }
  $links = [];
  foreach ( $files as $f ){
    $id_option = $model->inc->perm->is($f);
    $title = Str::sub($f, Str::len($cfg['url'].'/'));
    if ( $id_option !== null ){
      $opt = $model->inc->options->option($id_option);
      if ($opt['text'] && ($opt['code'] !== $opt['text'])){
        $title = $opt['text'];
      }
    	$menus = $model->db->rselectAll([
        'table' => "bbn_users_options_bits",
        'fields' => ["id_user_option", "cfg", "text"],      
        'join' =>[[
          'table' => "bbn_users_options",
          'on' => [
            'conditions' => [[
              'field' => "bbn_users_options_bits.id_user_option",        
              'exp' => "bbn_users_options.id"
           ]]
          ]
         ]],
        'where' => [
          'logic' => 'AND',
          'conditions' => [[
           	'field' => "bbn_users_options_bits.id_option",
            'value' => $id_option
          ],[
           	'field' => "bbn_users_options.id_option",
            'value' => $model->inc->options->fromCode('menus', 'menu', 'appui')
          ]]
        ] 
      ]);      
    }
    else{
      $menus = false;
    }
    $links[] = [
      'link' => $f,
      'text' => $title,
      'id_option' => $id_option,
      'menu' => !empty($menus),
      'n_menu' => !empty($menus) ? count($menus) : 0
    ];
    
  }
  $widgets[] = [
    'text' => $plugin,
    'items' => $links
  ];
}
return [
  'data' => $widgets
];