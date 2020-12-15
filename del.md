```php
<?php

function copyRelatedFields($ws_entity){
  global $current_user;
  global $adb;
  global $VTIGER_BULK_SAVE_MODE;
  // get WS id (id записи с префиксом номер модуля)
  $ws_id = $ws_entity->getId();
  $module = $ws_entity->getModuleName();
  if (empty($ws_id) || empty($module)) {
      return;
  }
  // get CRM id
  $crmid = vtws_getCRMEntityId($ws_id);
  if ($crmid <= 0) {
      return;
  }
  // so (SalesOrder)
  //получение объекта со всеми данными о текущей записи Модуля "MyModule"
  $soInstance = Vtiger_Record_Model::getInstanceById($crmid);
  $previousBulkSaveMode = $VTIGER_BULK_SAVE_MODE;
  $VTIGER_BULK_SAVE_MODE = true;
  if (!$soInstance) {
      return;
  }
