<?
$rootActivity = $this->GetRootActivity();
global $DB;
$workflowid = "{=Workflow:ID}";
$sql = "SELECT * FROM `b_bp_tracking` WHERE `workflow_id`='$workflowid' AND `action_name` = 'A6481_69712_43322_81479'";
$result = $DB->Query($sql, false);
$arrApprovers = [];
while ($row = $result->GetNext()){
	if(preg_match("/должны/",$row['ACTION_NOTE'])){
		$arrApprovers[] = $row['ACTION_NOTE'];
	}
}
$subject = $arrApprovers;
$search = 'Документ должны принять все пользователи из списка: ';
$trimmed = str_replace($search, '', $subject);
$subject = $trimmed;
$search = '=user:';
$trimmed = str_replace($search, '', $subject);
$result = str_replace(array("}","{"),'',$trimmed);
//$users = $result[0];
$arrMust = explode(",", $result[0]);


$documentId = $rootActivity->GetDocumentId();
//AddMessage2Log("documentId: ".print_r($documentId,true),"crm_bp");
AddMessage2Log("documentType: ".print_r($arrMust,true),"nichego_ne_znachit");


$set_approvers = $rootActivity->SetVariable("Golosyuwie",$arrMust);
//$set_approvers = $rootActivity->SetVariable("Golosyuwie",array("user_135", "user_100"));
//$set_approvers1 = $rootActivity->SetVariable("stroka",array($result[0]));
$golos = $rootActivity->GetVariable("Golosyuwie");
AddMessage2Log("documentType: ".print_r($golos,true),"Golosyuwie");
