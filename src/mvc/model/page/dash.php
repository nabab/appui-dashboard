<?php
if ($model->hasData('id', true)
  && \bbn\Str::isUid($model->data['id'])
  && ($dash = new \bbn\Appui\Dashboard($model->data['id']))
  && ($info = $dash->get())
  && ($cfg = $model->inc->pref->getClassCfg())
) {
  return [
    'name' => $info[$cfg['arch']['user_options']['text']],
    'icon' => $info['icon'],
    'info' => $info,
    'widgets' => $dash->getWidgets(),
    'availableWidgets' => $model->getModel($model->pluginUrl('appui-dashboard').'/data/configurator/widgets/tree')['data']
  ];
}