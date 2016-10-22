<?php
function createWhereClauseFromFilters($filtersToApplyList, $availableFiltersList){
	$queryClausesList = array();
	if(count($filtersToApplyList)){
		foreach($filtersToApplyList as $key => $value){
			$filterRecord = getRecordWhere($availableFiltersList, (Object) array('key' => 'ProductPropertyName', 'value' => $key));
			if($filterRecord != NULL){
				$filterValuesList = explode('|', $value);
				if($filterRecord->Type == 'Fixed'){
					array_push($queryClausesList, " ( " .$key ." IN (\"". implode("\" , \"", $filterValuesList) ."\") )");
				}
				else if($filterRecord->Type == 'Range'){
					$subClauses = array();
					foreach($filterValuesList as $filterValue){
						$values = explode("-", $filterValue);
						$subClause = " ( " . $key ." >= " .$values[0] ." AND " . $key ." <= " .$values[1] . " ) ";
						array_push($subClauses, $subClause);
					}
					array_push($queryClausesList, " (". implode(" OR ", $subClauses) .") ");
				}
			}
		}
		return implode(" AND ", $queryClausesList);
	}
	else return NULL;
}

function moneyFormatIndia($num){
	$explrestunits = "" ;
	if(strlen($num)>3){
		$lastthree = substr($num, strlen($num)-3, strlen($num));
		$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
		$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
		$expunit = str_split($restunits, 2);
		for($i=0; $i<sizeof($expunit); $i++){
			// creates each of the 2's group and adds a comma to the end
			if($i==0)
			{
				$explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
			}else{
				$explrestunits .= $expunit[$i].",";
			}
		}
		$thecash = $explrestunits.$lastthree;
	} else {
		$thecash = $num;
	}
	return $thecash; // writes the final format where $currency is the currency symbol.
}
?>