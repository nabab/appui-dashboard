<?php
/** @var bbn\Mvc\Controller $ctrl */
$ctrl->obj->success = false;  
if (\bbn\Str::isUid($ctrl->arguments[0])
  && isset($ctrl->arguments[1])
  && defined('BBN_REFERER')
){
  $actions = ['save', 'order'];
  if (\in_array($ctrl->arguments[1], $actions, true)){
    $ctrl->inc->dashboard->setCurrent($ctrl->arguments[0]);
    if ( $ctrl->obj->data = $ctrl->getObjectModel(APPUI_DASHBOARD_ROOT.'actions/'.$ctrl->arguments[1], $ctrl->post) ){
      $ctrl->obj->success = true;
    }
  }
  else{
    $ctrl->obj->error = _("Wrong action");
  }
}
else{
  $ctrl->obj->error = _("Wrong URL");
}
