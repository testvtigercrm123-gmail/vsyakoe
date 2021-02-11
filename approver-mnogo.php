$rootActivity = $this->GetRootActivity();
global $DB;
//const:-------
$workflowid = "{=Workflow:ID}";
$identificator = "A39269_87048_25965_76613"; // записываем идентификатор действия
$arrApprovers = [];
$arrRejectors = [];
//-------------
$sql = "SELECT * FROM `b_bp_tracking` WHERE `workflow_id`='$workflowid' AND `action_name` = '$identificator'";
$result = $DB->Query($sql, false);

while ($row = $result->GetNext()){
	if ($row['MODIFIED_BY'] != ""){
		if(preg_match("/одобрил/",$row['ACTION_NOTE'])){
			$arrApprovers[] = 'user_' . $row['MODIFIED_BY'];
		}
		if(preg_match("/отклонил/",$row['ACTION_NOTE'])){
		  $arrRejectors[] = 'user_' . $row['MODIFIED_BY'];
		}
	}
}

$arrGolosyuwie = $rootActivity->GetVariable("approve");
$arrNoticed = array_diff($arrGolosyuwie, $arrApprovers);
$arrNoticed = array_values(array_filter($arrNoticed));
$arrNoticed = array_diff($arrNoticed, $arrRejectors);
$arrNoticed = array_values(array_filter($arrNoticed));
$count_noticed = count($arrNoticed, COUNT_RECURSIVE);

if ($count_noticed >= 1) {
	for ($i = 0; $i < $count_noticed; $i++) {
                $Notice_User = 'Noticed_user' . $i;
                  ob_start();
                  echo "$Notice_User";
                $variable = ob_get_clean();
		$set_noticed = $rootActivity->SetVariable("$variable","$arrNoticed[$i]");	
	}
}
