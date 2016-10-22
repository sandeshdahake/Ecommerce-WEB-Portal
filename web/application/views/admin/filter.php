<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
	.add-subcategory-heading{ text-align:center}
	.panel{ font-case:upppercase}
</style>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					Filters
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<table id="subcategoryTable" class="table " cellspacing="1px">
								<thead>
									<th class="add-subcategory-heading" colspan="2">
										Add New Filter
									</th>
								</thead>
								<tr>
									<td class="subcategory-name-label" >
										Filter Name
									</td>
									<td class="subcategory-name">
										<input id="filterName" class="input-sm form-control" type="text"/>
									</td>
								</tr>
								<tr>
									<td>
										Product Property Name
									</td>
									<td>
										<Select id="property" class="input form-control">
											<option value="">Select Property</option>
											<option value="Brand">Brand</option>
											<option value="Price">Price</option>
											<option value="OperatingSystem">OperatingSystem</option>
											<option value="RearCamera">RearCamera</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										Select Product Subcategory
									</td>
									<td>
										<Select id="subcategory" class="input form-control">
											<option value="">Select Subcategory</option>
											<?php
												foreach($subcategories as $subcategory){
													echo '<option value="'.$subcategory->Id.'">'.$subcategory->Name.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										Select Filter Type
									</td>
									<td>
										<Select id="type" class="input form-control">
											<option value="">Select Type</option>
											<option value="Fixed">Fixed</option>
											<option value="Range">Range</option>
											<option value="Contains">Contains</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input onClick="createFilter();" type="button" class="btn btn-success form-control" name="Create" value="Create" >
									</td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<table id="filterList" class="table col-md-6">
								<thead>
									<th>
										Sr. No.
									</th>
									<th>
										Filter Names
									</th>
									<th>
										Action
									</th>
								</thead>
								<tbody>
								<?php
								
								if(isset($filters)){
									$i = 1;
									$trList = '';
									foreach($filters as $filter){
										echo '<tr><td>'.$i.'</td><td>'.$filter->Name.
												  '</td><td><a href="'.base_url().'AdminController/filterdetails?fid='.$filter->Id.'">'.
												  'Update</a></td></tr>';
										$i++;
									}
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


 <script>
	function createFilter(){
		// create json
		// call ajax method
		console.log('calling ajax');
		ajaxMethodToCreate(createJson());
		console.log('ajax called');
	}
	
	function createJson(){
		var data = '{"Type":"'+$('#type').val()+'","Name":"'+$('#filterName').val()+
				   '","ParentSubcategoryId":'+$('#subcategory').val()+',"ProductPropertyName":"'+$('#property').val()+'"}';
		console.log(data);
		return data;
	}
	
	function ajaxMethodToCreate(jsonData){
		$.ajax({
			type: "POST",
			url: "http://localhost/smartprice/adminController/addfilter",
			data: {data:jsonData},
			success: function(res){appendFilterList(res);}
		});
	}
	function appendFilterList(res){
		
		$('#filterList tbody').append(filterHtml(res));
		try{
			
		}
		catch(e){
			console.log('Failed');
		}
	}
	
	function filterHtml(res){
		var obj = JSON.parse(res);
		var t = $('#filterList tr').length;
		var url = $(location).attr("href")+'/../filterdetails?fid='+obj['Id'];
		var html = '<tr><td>'+t+'</td><td>'+obj['Name']+'</td><td><a href="'+url+'">Update</a></td></tr>';
		console.log(html);
		return html;
	}
	
</script>
