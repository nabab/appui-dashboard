<?php
if ($ctrl->hasArguments()) {
  try {
    $ctrl->inc->dashboard->setCurrent($ctrl->arguments[0]);
    $d = $ctrl->inc->dashboard->get();
    $ctrl->setIcon('nf nf-fa-dashboard')
     ->combo(_("Dashboard").': '.$d['text'], array_merge(
       $ctrl->getModel(APPUI_DASHBOARD_ROOT.'home'),
       ['id' => $ctrl->arguments[0]]
      ));
  }
  catch (Exception $e) {
    $ctrl->obj->error = $e->getMessage();
  }
}
