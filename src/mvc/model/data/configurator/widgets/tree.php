<?php
if ($all = $model->inc->options->fullTreeRef('widgets', 'dashboard', 'appui')) {
  if (!empty($all['items'])) {
    function filterItems($items){
      foreach ($items as $i => $item) {
        if (!empty($item['id_alias'])) {
          unset($items[$i]);
          continue;
        }
        if (!empty($item['items'])) {
          $items[$i]['items'] = filterItems($items[$i]['items']);
        }
      }
      return array_values($items);
    }
    $all['items'] = filterItems($all['items']);
  }
  return [
    'data' => empty($all) ? [] : $all['items']
  ];
}
return ['data' => []];