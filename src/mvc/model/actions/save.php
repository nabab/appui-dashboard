<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 31/05/2017
 * Time: 11:32
 * @var \bbn\mvc\model $model
 */

if ( !empty($model->data['id']) && !empty($model->data['cfg']) ){
  // Normal widget
  if ( $cfg = $model->inc->pref->get_by_option($model->data['id']) ){
   
    $cfg = \bbn\x::merge_arrays($cfg, $model->data['cfg']);
    if ( !empty($cfg) ){
      
      return ['success' => $model->inc->pref->set_by_option($model->data['id'], $cfg)];
    }  
  }
  // User's personal widget
  else if ( $old = $model->inc->pref->get($model->data['id'], false) ){
    if ( ($cfg = json_decode($old['cfg'], true)) && !empty($cfg['widget']) ){
      $cfg['widget'] = \bbn\x::merge_arrays($cfg['widget'], $model->data['cfg']);  
      return ['success' => $model->inc->pref->set_cfg($model->data['id'], $cfg)];  
    }       
  }
  else{
    return ['success' => $model->inc->pref->add($model->data['id'], $model->data['cfg'])];  
  }  
}
return ['success' => false];
