<?php

?>
<style>
	.field-column{ text-align:center}
	.field-lable{}
</style>
<input type="hidden" value="<?=$record->Name?>" id="subcategoryId">
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					Add/Remove Fields
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-5">
							<table  class="table" cellspacing="1px">
								<tr >
									<td class="property-name" >
										Subcategory Name
									</td>
									<td class="property-input">
										<input id="subcategoryName" class="input-sm form-control" value="<?= $record->Name ?>" type="text"/>
									</td>
									<td>
										<input type="button" class="btn btn-info link-green" id="addProperty" name="add_field" value="Add Field">
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<table id="subcategoryTable" class="table" cellspacing="1px">
							<thead>
								<tr style="text-align:center">
									<th class="field-column">Field Label</th>
									<th class="field-column">Field Name </th>
									<th class="field-column">Field Type </th>
									<th class="field-column">Action </th>
								</tr>
							</thead>
						</table>
					</div>
					<input type="button" onClick="updateSubcategory();" class="btn btn-success" name="update" value="update" >
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$("#addProperty").click(function() {
		addProperty();
	});
	// method to add property row
	function addProperty(){
		// count row
		var count = $("#subcategoryTable tr").length;
		$("#subcategoryTable ").append(htmlForPropertyRow(count));
	}
	function htmlForPropertyRow(count){
		var html = '<tr id="property_'+count+'" ><td><input id="label_'+count+'" onChange="populateFieldName(this.id);"  class="input-sm form-control field-lable" type="text"/>'+
				   '</td><td><input id="name_'+count+'" class="input-sm form-control" type="text" disabled="disabled"/>'+
				   '</td><td>'+
				   '<select id="type_'+count+'" class="input-sm form-control" Name="DataType" >'+
				   '<option value="Text">Text</option>'+
			       '<option value="Int">Integer</option>'+
			       '</select></td><td><input onClick="hideRow('+count+')" type="button" class="btn btn-danger"  name="remove" value="Remove"></td></tr>';
	    return html;
	}
	// While collecting data, only select visible rows
	function populateFieldName(id){
		var count = id.split('_')[1];
		$('#name_'+count).val($('#'+id).val().replace(/\s/g,''));
	}
	function hideRow(count){
		$('#property_'+count).hide();
	}
	function updateSubcategory(){
		ajaxMethodToupdate(createjson());
		//createjson();
	}
	function createjson(){
		var count = $("#subcategoryTable tr").length;
		console.log('count '+count);
		var json = '{';
		var i = 0;
		for(i=0;i<=count;i++){
			console.log('#property_'+i+' '+ $('#property_'+i).is(':visible'));
			if($('#property_'+i).is(':visible')){
				if(json != '{') json = json + ',';
				json = json + '"field'+i+'":'+'{"name":"'+$('#name_'+i).val()+'","label":"'+$('#label_'+i).val()+'","type":"'+$('#type_'+i).val()+'"}';
			}
		}
		if(json != '{') json = json + ',';
		json = json + '"subcategory":{"subcategoryId":"'+$('#subcategoryId').val()+'","subcategoryName":"'+$('#subcategoryName').val()+'"}}';
		console.log(json);
		return json;
	}
	
	function ajaxMethodToupdate(jsonData){
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>AdminController/updatesubcategory",
			data: {data:jsonData},
			success: function(res){console.log('In responce');console.log(res);}
		});
	}
</script>