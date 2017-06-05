<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 31/05/2017
 * Time: 11:32
 */

/** @var \bbn\mvc\model $model */
if ( isset($model->data['id']) ){
  return ['success' => $model->inc->pref->add($model->data['id'], ['hidden' => true])];
}