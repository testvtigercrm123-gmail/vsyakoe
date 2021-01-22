<?
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
$count_approve = count($arrApprovers, COUNT_RECURSIVE);
//AddMessage2Log("documentType: ".print_r($arrApprovers,true),"nichego_ne_znachit");
$count_golosyuwie = count($arrGolosyuwie, COUNT_RECURSIVE);
$arrNoticed = [];

if ($count_approve == 1) {
	  for ($a = 0; $a < $count_golosyuwie; $a++) {
//			AddMessage2Log("result:[$a]: ".print_r($arrGolosyuwie[$a],true),"nichego_ne_znachit");
			if ( $arrGolosyuwie[$a] !== $arrApprovers[0] ) {
				$Notice_User = 'Utverd_user' . $a;
				$arrNoticed[] = $arrGolosyuwie[$a];
				AddMessage2Log("result:[$a]: ".print_r($arrGolosyuwie[$a],true),"yvedomit");
			}
		}
		
		$count_noticed = count($arrNoticed, COUNT_RECURSIVE);
		
		for ($b = 0; $b < $count_golosyuwie; $b++) {
			  $Notice_User = 'Utverd_user' . $b;
			    ob_start();
				    echo "$Notice_User";
			    $variable = ob_get_clean();
				
			  $set_noticed = $rootActivity->SetVariable("$variable","$arrNoticed[$b]");
		}
		AddMessage2Log("Array: ".print_r($arrNoticed,true),"pobedil");
}
