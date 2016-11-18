<?php
/** @var $model \bbn\mvc\model */
return json_decode($model->db->select_one('apst_stats', 'res', ['nom' => 'cgar_exp_90']), 1);