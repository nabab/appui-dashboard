<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 31/05/2017
 * Time: 11:32
 */

/** @var \bbn\mvc\model $model */

if ( isset($model->data['id'], $model->data['cfg']) ){
  if ( $cfg = $model->inc->pref->get_by_option($model->data['id']) ){
    $cfg = \bbn\x::merge_arrays($cfg, $model->data['cfg']);
    return ['success' => $model->inc->pref->set_by_option($model->data['id'], $cfg)];  
  }
  return ['success' => $model->inc->pref->add($model->data['id'], $model->data['cfg'])];
}