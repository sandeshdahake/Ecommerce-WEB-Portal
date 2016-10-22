<?php
function createWhereClauseFromFilters($filtersToApplyList, $availableFiltersList){
	$queryClausesList = array();
	foreach($filtersToApplyList as $key => $value){
		$filterRecord = getRecordWhere($availableFiltersList, (Object) array('key' => 'Name', 'value' => $key));
		$filterValuesList = explode('%7C', $value);
		if($filterRecord->Type == 'Fixed'){
			array_push($queryClausesList, $key ." IN (\" ". implode("\" , \"", $filterValuesList) ."\") ");
		}
		else if($filterRecord->Type == 'Range'){
			$subClauses = array();
			foreach($filterValuesList as $filterValue){
				$values = explode("-", $filterValue);
				$subClause = $key ." >= " .$values[0] ." AND " . $key ." <= " .$values[1];
				array_push($subClauses, $subClause);
			}
			array_push($queryClausesList, " (". implode(" OR ", $subClauses) .") ");
		}
	}
	
	return implode(" AND ", $queryClausesList);
}


?>