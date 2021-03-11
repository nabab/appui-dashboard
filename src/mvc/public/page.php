<?php
$users = array_values(array_filter($ctrl->inc->user->getManager()->fullList(), function($u){
  return !!$u['active'];
}));
$groups = $ctrl->inc->user->getManager()->textValueGroups();
\bbn\X::sortBy($users, 'text', 'ASC');
\bbn\X::sortBy($groups, 'text', 'ASC');
$ctrl
  ->addData([
    'prefCfg' => $ctrl->inc->pref->getClassCfg(),
    'optCfg' => $ctrl->inc->options->getClassCfg(),
    'root' => APPUI_DASHBOARD_ROOT,
    'users' => $users,
    'groups' => $groups
  ])
  ->setUrl(APPUI_DASHBOARD_ROOT . 'page')
  ->setIcon('nf nf-mdi-view_dashboard')
  ->setColor('teal', 'white')
  ->combo(_('Dashboards configurator'), true);