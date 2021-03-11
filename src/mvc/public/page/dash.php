<?php
  if (!empty($ctrl->arguments) && \bbn\Str::isUid($ctrl->arguments[0])) {
    $idDash = $ctrl->arguments[0];
    $ctrl->addData(['id' => $idDash])
      ->setUrl(APPUI_DASHBOARD_ROOT . 'page/dash/' . $idDash)
      ->setIcon('$icon')
      ->combo('$name', true);
  }