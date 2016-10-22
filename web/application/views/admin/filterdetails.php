<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<style>
	.field-column{ text-align:center}
	.field-lable{ }
</style>
<script>
		var app= angular.module('filterdetailsApp', []);
		app.controller('filterdetailsController',function($scope){
			
		});	
	</script>
<div class="container" ng-app="filterdetailsApp">
	<div class="row"  >
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					Update Filter Details
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-5">
							<table  class="table" cellspacing="1px">
								<tr >
									<td class="property-name" >
										Filter Name
									</td>
									<td class="property-input">
										<input id="filterName" class="input-sm form-control" value="<?= $filter->Name ?>" type="text"/>
									</td>
									<td>
										<input type="button" class="btn btn-info link-green" id="addProperty" name="add_field" value="Add Field">
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						
						<form ng-controller="filterdetailsController" name="filterDetails" >
						<table id="subcategoryTable" class="table" cellspacing="1px">
							<thead>
								<tr style="text-align:center">
									<th class="field-column">Fixed Value</th>
									<th class="field-column">Priority</th>
									<th class="field-column">Action</th>
								</tr>
								
								<tr  >
									<td><input class="input-sm form-control field-lable fixedValue" ng-model="detail.Value" type="text" /></td>
									<td><input class="input-sm form-control field-lable priority" ng-model="detail.Priority" type="text" /></td>
									<td><input onClick="hideRow('.$i.')" type="button" class="btn btn-danger"  name="remove" value="Remove"></td>
								</tr>
							</thead>
						</table>
						</form>
					</div>
					<input type="button" onClick="updateSubcategory();" class="btn btn-success" name="update" value="update" >
				</div>
			</div>
		</div>
	</div>
</div>