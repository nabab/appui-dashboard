<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$widgets_id = $model->inc->options->from_code('default', 'dashboard', 'appui');
$dashboard =  $model->inc->options->option($model->inc->options->from_code('dashboard', 'appui'));
$widgets = $model->inc->options->full_options($widgets_id);
$list = $model->inc->options->option($widgets_id);

//die(var_dump($dashboard));
return [
   'widgets' => $widgets,
   'list' => $list
  ];