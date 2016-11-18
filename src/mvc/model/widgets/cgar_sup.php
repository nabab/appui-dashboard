<?php
/** @var $model \bbn\mvc\model */
if ( $res = $model->db->select_one('apst_stats', 'res', ['nom' => 'cgar_sup']) ){
	return json_decode($res, 1);
}
return [];