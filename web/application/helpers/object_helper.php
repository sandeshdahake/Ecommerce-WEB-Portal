<?php 
// record with property
function relateRecords( $parentRecordsList, $primaryKey, $childRecordsList, $foreignKey, $relatedListName){
	if(count($parentRecordsList) > 0 &&  count($childRecordsList) > 0){
		foreach($childRecordsList as $childRecord){
			foreach($parentRecordsList as $parentRecord){
				if($childRecord->{$foreignKey} == $parentRecord->{$primaryKey}){
					if(!property_exists($parentRecord, $relatedListName)){
						$parentRecord->{$relatedListName} = array();
					}
					array_push($parentRecord->{$relatedListName}, $childRecord);
				}
			}
		}
	}
	return $parentRecordsList;
}

// record with property
function getRecordWhere( $recordsList, $param ){
	foreach($recordsList as $record){
		foreach($record as $key => $value){
			if($key == $param->key && $value == $param->value){
				return $record;
			}
		}
	}
	return NULL;
}
?>