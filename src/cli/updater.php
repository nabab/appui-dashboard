<?php
/** @var $ctrl \bbn\mvc\ctrl */

use bbn\X;

X::adump('Hello from the updater...');
$appui = new \bbn\Appui();
$pref = new \bbn\User\Preferences($appui->getDb());
$perm = new \bbn\User\Permissions();
if ($res = $appui->updateMenus()) {
  echo $res . _('menus changed');
}
