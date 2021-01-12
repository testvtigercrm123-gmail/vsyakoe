use Bitrix\Main\Loader;
Loader::includeModule("iblock");
Loader::includeModule('crm');
Loader::includeModule('bizproc');
use \Bitrix\Iblock;
use \Bitrix\Crm;
use \Bitrix\Bizproc;

$idcur=4062621;
$arOrder = ["ID" => "DESC"];
$arFilter = Array("ID"=>$idcur, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$arSelect = Array("*","PROPERTY_*");
$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){
	$idBizproc = $ob->GetProperties()['ID_BIZPROC']['VALUE'];
}


//$idBizproc = '5ffd59f421a200.17708838';

global $DB;
$sql = "SELECT * FROM `b_bp_tracking` WHERE `workflow_id`='$idBizproc' AND `action_name` = 'A43783_90698_74603_27409'";
$result = $DB->Query($sql, false);
$arrApprovers = [];
while ($row = $result->GetNext()){
	if ($row['MODIFIED_BY'] != ""){
		if(preg_match("/одобрил/",$row['ACTION_NOTE'])){
			$arrApprovers[] = $row['MODIFIED_BY'];
		}
		if(preg_match("/отклонил/",$row['ACTION_NOTE'])){
		$arrApprovers = [];
		}
	}
}

print_r($arrApprovers);
$otvet = $idBizproc;
//var_dump($otvet);
echo "---RESULTAT---\n";
echo "<pre>"; print_r($otvet); echo "</pre>\n";
