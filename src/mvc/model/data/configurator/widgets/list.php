<?php
$opts = !empty($model->data['data']['id'])
  ? $model->inc->options->fullOptionsRef($model->data['data']['id'])
  : $model->inc->options->fullOptionsRef('widgets', 'dashboard', 'appui');

$root = $model->pluginUrl('appui-dashboard');
foreach ($opts as $i => $opt) {
  if (!empty($opt['id_alias'])) {
    unset($opts[$i]);
    continue;
  }
  $tmp = $opt;
  while ($tmp['code'] !== 'widgets') {
    $tmp = $model->inc->options->option($tmp['id_parent']);
  }
  $p = $model->inc->options->code($tmp['id_parent']);
  if ($p !== $root) {
    $opts[$i]['plugin'] = $model->inc->options->code($model->inc->options->option($model->inc->options->option($tmp['id_parent'])['id_parent'])['id_parent']);
  }
  else {
    $opts[$i]['plugin'] = $root;
  }
}
$opts = array_values($opts);
\bbn\X::sortBy($opts, 'text', 'asc');
return [
  'data' => $opts,
  'total' => count($opts)
];