<?php
/** @var \bbn\mvc\model $model */

return [
  'data' => $model->inc->dashboard->get_widgets(
    $model->inc->options->from_code('default', 'dashboard', 'appui'),
    $model->plugin_url().'/data/'
  ),
  'root' => APPUI_DASHBOARD_ROOT
];