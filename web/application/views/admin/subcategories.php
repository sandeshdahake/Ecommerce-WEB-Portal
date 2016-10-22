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
					Subcategories
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<table id="subcategoryTable" class="table " cellspacing="1px">
								<thead>
									<th class="add-subcategory-heading" colspan="2">
										Add New Subcategory 
									</th>
								</thead>
								<tr>
									<td class="subcategory-name-label" >
										Subcategory Name
									</td>
									<td class="subcategory-name">
										<input id="subcategoryName" class="input-sm form-control" type="text"/>
									</td>
								</tr>
								<tr>
									<td>
										Select Category
									</td>
									<td>
										<Select id="category" class="input form-control">
											<option value="1">Electronics</option>
											<option value="2">Other</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input onClick="createSubcategory();" type="button" class="btn btn-success form-control" name="Create" value="Create" >
									</td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<table id="subcategoryList" class="table col-md-6">
								<thead>
									<th>
										Sr. No.
									</th>
									<th>
										Subcategory Names
									</th>
									<th>
										Action
									</th>
								</thead>
								<tbody>
								<?php
								$i = 1;
								$trList = '';
								foreach($records as $record){
									echo '<tr><td>'.$i.'</td><td>'.$record->Name.
											  '</td><td><a href="'.base_url().'AdminController/editsubcategory?sid='.$record->Id.'">'.
											  'Edit</a></td></tr>';
									$i++;
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
	function createSubcategory(){
		// create json
		// call ajax method
		console.log('calling ajax');
		ajaxMethodToCreate(createJson());
		console.log('ajax called');
	}
	
	function createJson(){
		var data = '{"CategoryId":'+$('#category').val()+',"Name":"'+$('#subcategoryName').val()+'"}';
		console.log(data);
		return data;
	}
	
	function ajaxMethodToCreate(jsonData){
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>/AdminController/addsubcategory",
			data: {data:jsonData},
			success: function(res){appendSubcategoryList(res);}
		});
	}
	function appendSubcategoryList(res){
		//subcategoryList
		$('#subcategoryList tbody').append(subcategoryHtml(res));
		try{
			
		}
		catch(e){
			console.log('Failed');
		}
	}
	
	function subcategoryHtml(res){
		var obj = JSON.parse(res);
		var t = $('#subcategoryList tr').length;
		var url = $(location).attr("href")+'/../editsubcategory?sid='+obj['CategoryId'];
		console.log(obj);
		var html = '<tr><td>'+t+'</td><td>'+obj['Name']+'</td><td><a href="'+url+'">Edit</a></td></tr>';
		console.log(html);
		return html;
	}
	
</script>
