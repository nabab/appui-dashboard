<?php
/** @var bbn\Mvc\Controller $ctrl */
$ctrl->obj->success = false;  
if ( isset($ctrl->arguments[0]) && defined('BBN_REFERER') ){
  $actions = ['save', 'order'];
  if ( \in_array($ctrl->arguments[0], $actions, true) ){
    if ( $ctrl->obj->data = $ctrl->getObjectModel('./actions/'.$ctrl->arguments[0], $ctrl->post) ){
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
