<?php
/** @var $ctrl  \bbn\mvc\controller */
$ctrl->data = $ctrl->get_model();

echo $ctrl
    ->set_title(_("Dashboard"))
    ->add_js($ctrl->data['data'])
    ->get_view().
  $ctrl->get_less();
