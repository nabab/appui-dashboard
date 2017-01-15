<?php
/** @var $ctrl  \bbn\mvc\controller */
$ctrl->data = $ctrl->get_model();

echo $ctrl->combo(_("Tableau de bord"), '$data');
