??
$rootActivity = $this->GetRootActivity();
global $DB;
$workflowid = "{=Workflow:ID}";
$sql = "SELECT * FROM `b_bp_tracking` WHERE `workflow_id`='$workflowid' AND `action_name` = 'A6481_69712_43322_81479'";
$result = $DB->Query($sql, false);
$arrApprovers = [];
while ($row = $result->GetNext()){
	if ($row['MODIFIED_BY'] != ""){
		if(preg_match("/одобрил/",$row['ACTION_NOTE'])){
			$arrApprovers[] = 'user_' . $row['MODIFIED_BY'];
		}
		if(preg_match("/отклонил/",$row['ACTION_NOTE'])){
		  $arrApprovers = [];
		}
	}
}

$arrGolosyuwie = $rootActivity->GetVariable("Golosyuwie");
//$count_approve = count($arrApprovers, COUNT_RECURSIVE);
//$count_golosyuwie = count($arrGolosyuwie, COUNT_RECURSIVE);
$arrNoticed = array_diff($arrGolosyuwie, $arrApprovers);
$arrNoticed = array_values(array_filter($arrNoticed));
$count_noticed = count($arrNoticed, COUNT_RECURSIVE);

if ($count_noticed >= 1) {
	for ($i = 0; $i < $count_noticed; $i++) {
        $Notice_User = 'Utverd_user' . $i;
        ob_start();
            echo "$Notice_User";
        $variable = ob_get_clean();        
		$set_noticed = $rootActivity->SetVariable("$variable","$arrNoticed[$i]");	
	}
    AddMessage2Log("Array: ".print_r($arrNoticed,true),"pobedil");
}
