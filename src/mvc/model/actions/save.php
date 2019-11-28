<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 31/05/2017
 * Time: 11:32
 * @var \bbn\mvc\model $model
 */
if ( !empty($model->data['id']) && !empty($model->data['cfg']) ){
  return ['success' => $model->inc->dashboard->save($model->data)];
}
return ['success' => false];
