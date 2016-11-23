<?php
/** @var $ctrl  \bbn\mvc\controller */
$ctrl->data = $ctrl->get_model();

echo $ctrl
    ->set_title(_("Tableau de bord v2"))
    ->add_js($ctrl->data['data'])
    ->get_view().
  $ctrl->get_less();
