<?php
/** @var \bbn\mvc\controller $ctrl */
$ctrl->obj->success = false;  
if ( isset($ctrl->arguments[0]) ){
  $actions = ['move', 'show', 'hide', 'save'];
  
  if ( \in_array($ctrl->arguments[0], $actions, true) ){
    
    if ( $ctrl->obj->data = $ctrl->get_object_model('./actions/'.$ctrl->arguments[0], $ctrl->post) ){
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
