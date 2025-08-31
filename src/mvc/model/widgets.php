<?php

/** @var bbn\Mvc\Model $model */
$widgets_id = $model->inc->options->fromCode('default', 'dashboard', 'appui');
$dashboard =  $model->inc->options->option($model->inc->options->fromCode('dashboard', 'appui'));
$widgets = $model->inc->options->fullOptions($widgets_id);
$list = $model->inc->options->option($widgets_id);

//die(var_dump($dashboard));
return [
   'widgets' => $widgets,
   'list' => $list
  ];