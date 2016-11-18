<?php
if ( isset($model->data['model']) ){
	$models = [
		'adherents' => [
			'level' => 1,
			'value' => 'id',
			'text' => 'nom'
		],
		'lieux' => [
			'level' => 1,
			'value' => 'id',
			'text' => 'adresse'
		],
		'tiers' => [
			'level' => 1,
			'value' => 'id',
			'text' => ['nom', 'prenom'],
			'separator' => ' '
		],
	];
	$order = false;
	if ( isset($models[$model->data['model']]) ){
		$m = $models[$model->data['model']];
		if ( isset($m['value'], $m['text']) ){
			$sql = "SELECT ";
			if ( is_array($m['value']) && count($m['value']) === 1 ){
				$m['value'] = $m['value'][0];
				
			}
			if ( is_array($m['value']) && count($m['value']) > 1 ){
				$sql .= " CONCAT(`".implode("`,`", $m['value'])."`), ";
			}
			else if ( is_string($m['value']) && !empty($m['value']) ){
				$sql .= " `$m[value]`, ";
			}
			if ( is_array($m['text']) && count($m['text']) === 1 ){
				$m['text'] = $m['text'][0];
				
			}
			if ( is_array($m['text']) && count($m['text']) > 1 ){
				$sql .= " CONCAT(`".implode("`,`", $m['text'])."`) ";
				$order = "`".implode("`,`", $m['text'])."`";
			}
			else if ( is_string($m['text']) && !empty($m['text']) ){
				$sql .= " `$m[value]` ";
				$order = " `$m[value]` ";
			}
			if ( $order ){
				$sql = substr($sql, 0, strrpos($sql, ","));
        $sql .= " FROM $model->data[model] ORDER BY $order";
				
			}
		}
	}
}