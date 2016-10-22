<section>
<?php echo $headingBanner;?>

<div class="clearifix"></div>
<script src="<?= base_url(); ?>assets/js/angular.min.js"></script>
<script>
	var app = angular.module('ProductsListApp', []);
	
	app.controller('ProductsFilterController', ['$scope', '$http', function($scope, $http){
		var subcategory = "<?= $subcategoryName; ?>";
		$scope.appliedFilters = {};
		var paramsStr = decodeURIComponent(window.location.hash.substring(2, window.location.hash.length));
		console.log("paramsStr :: " + paramsStr);
		if(paramsStr){
			paramStrList = paramsStr.split("&");
			if(paramStrList.length > 0){
				paramStrList.forEach(function(paramStr){
					var keyValParam = paramStr.split("=");
					if(keyValParam[1]){
						var values = keyValParam[1].split("|");
						$scope.appliedFilters[keyValParam[0]] = values;
						
					}
				});
			}
		}
		
		$scope.pagination = {};
		$scope.appliedFilters["sortby"] = [];
		$scope.appliedFilters["sortby"][0] = "popularity";
		
		$scope.productsChunksList = [];
		$scope.compareProductsList = [];
		
		$scope.$watch('appliedFilters', function(newVal, oldVal){
			if(!angular.equals(newVal, oldVal)){
				if(typeof newVal["pageNumber"] != "undefined" && typeof oldVal["pageNumber"] != "undefined"){
					if(parseInt(newVal["pageNumber"][0]) == parseInt(oldVal["pageNumber"][0])){
						$scope.appliedFilters["pageNumber"][0] = 1;
					}
				}
				getFilteredProducts();
			}
		}, true);
		
		$scope.setPageNumber = function(pageNumber){
			$scope.appliedFilters["pageNumber"] = [];
			$scope.appliedFilters["pageNumber"][0] = pageNumber; 
		}
		
		// toggle selection for a given fruit by name
		$scope.toggleFiltersSelection = function (filterName, value) {
			if(typeof $scope.appliedFilters[filterName] == 'undefined'){
				 $scope.appliedFilters[filterName] = [];
			}
			var idx = $scope.appliedFilters[filterName].indexOf(value);
			// is currently selected
			if (idx > -1) {
			 $scope.appliedFilters[filterName].splice(idx, 1);
			}

			// is newly selected
			else {
				$scope.appliedFilters[filterName].push(value);
			}
		};
		function getCompareAddedProducts(){
			$http.get("<?= base_url();?>CompareController/getCompareAddedProducts/" + subcategory)
				.then(
				function(result){
					console.log('compare added products');
					console.log(result.data);
					$scope.compareProductsList = result.data;
				},
				function(result, error){
				
				
				}
			);
		}
		getCompareAddedProducts();
		
		$scope.toggleComparedProduct = function(clickedProduct){
			$http.get("<?= base_url();?>CompareController/handleAddToCompare/" + subcategory, 
					{
						params : {product:clickedProduct }
					})
				.then(
				function(result){
					console.log(result.data);
					$scope.compareProductsList = result.data;
				},
				function(result, error){
				
				
				}
			);
			
		}
		
		$scope.isAddedToCompare = function(productId){
			var isAddedToCompare = false;
			angular.forEach($scope.compareProductsList, function(product){
				if(product.Id == productId) isAddedToCompare = true;
			});
			return isAddedToCompare;
		}
			
		function createParametersStr(paramsList){
			var paramsStr = '';
			paramsList.forEach(function(param, valuesList){
				paramsStr += param + "=" + valuesList.join("|") + "&";
			});
			return paramsStr;
		}
		
		function chunk(arr, size) {
			if(arr){
				var newArr = [];
				for (var i=0; i<arr.length; i+=size) {
					newArr.push(arr.slice(i, i+size));
				}
				return newArr;
			}
			return null;
		}
		
		function getFilters(){
			var subcategory = "<?= $subcategoryName; ?>";
			$http.get("<?= base_url();?>SubcategoryController/filters/"+ subcategory)
			.then(
				// success function
				function(response) {
					console.log('response :  ');
					console.log(response);
					$scope.filtersList = response.data;
				}, 
				// failure function
				function(response, error){
					
				}
			);
		}
		
		function getProducts(filters, sortBy){
			var subcategory = "<?= $subcategoryName; ?>";
			console.log("in getparameters");
			$http.get("<?= base_url();?>SubcategoryController/products/" + subcategory, 
				{
					params:{ filters:filters, sortBy:sortBy }
				})
			.then(
				// success function
				function(response) {
					console.log('response :  ');
					console.log(response);
					angular.forEach(response.data.Products, function(product){
						product.ratingWidth = parseInt(product.Rating)*20;
					});
					
					$scope.productsChunksList = chunk(response.data.Products,3);
					$scope.pagination.totalProducts = parseInt(response.data.Summary.TotalProducts);
					$scope.pagination.pageSize = parseInt(response.data.Summary.PageSize);
					$scope.pagination.pageNumber = parseInt(response.data.Summary.PageNumber);
					
					
					
					$scope.pagination.pages = [];
					for(var i=-2; i<3; i++){
						var pageNo = $scope.pagination.pageNumber + i;
						if(pageNo > 0 && pageNo <= ($scope.pagination.totalProducts/$scope.pagination.pageSize)+1){
							if(i == -1){
								$scope.pagination.prev =pageNo;
							}
							if(i == 1){
								$scope.pagination.next =pageNo;
							}
							$scope.pagination.pages.push($scope.pagination.pageNumber + i );
						}
					}
					
					$scope.hotProperties = response.data.hotProperties;
				}, 
				// failure function
				function(response, error){
					
				}
			);
		}
		
		function getFilteredProducts(){
			
			var filtersStr = "";
			//if(Object.keys($scope.appliedFilters).length > 0){
				angular.forEach($scope.appliedFilters, function(values, filter ){
					filtersStr += "&" +filter + "=";
					if(values.length > 0){
						filtersStr += values.join('|');
					}
				});
				
				filtersStr = filtersStr.substring(1, filtersStr.length);
				//filtersStr = "sortby=" + $scope.sortBy + filtersStr;
				window.location.hash = filtersStr;
				console.log(filtersStr);
				getProducts(filtersStr);
			//}
		}
		
		function init(){
			getFilters();
			getFilteredProducts();
		}
		init();
		
		function addToCompare(productId){
		console.log('Product Id : ' + productId);
			$http.post("<?= base_url();?>CompareController/handleAddToCompare" + subcategory, 
					{
						params:{ productId:productId }
					})
				.then(
				function(result){
					console.log(result);
					
				}, 
				function(result, error){
				
				
				}
			);
		
		}
	}]);
</script>
<div class="container" ng-app="ProductsListApp" ng-controller="ProductsFilterController">
	<div class="row">
		<div class="content">
			<div class="content_top">
				<div class="section-title">
					<div class="sortingSection">
						<select ng-model="appliedFilters.sortby[0]">
							<option value="priceLowToHigh">Price - Low to High</option>
							<option value="priceHighToLow">Price - High to Low</option>
							<option value="popularity">Popularity</option>
						</select>
					</div>
				</div>
				<div class="clearifix"></div>
			</div>
		</div>
	</div>
	<div clas="row">
	<div class="col-md-3">
		<div ng-include="'ProductFilters.html'"></div>
	</div>
		<div id="ProductsView" class="col-md-9">
			<div ng-if="productsChunksList && productsChunksList.length > 0" id="productsList" ng-include="'ProductListTemplate'"></div>
			<div ng-if="!productsChunksList || productsChunksList.length == 0" class="">No products found</div>
		</div>
	</div>
	<div class="compare-holder panel">
		<div class="panel-header">
			Compare Products
		</div>
		<div class="panel-body">
			<ul ng-if="compareProductsList && compareProductsList.length>0">
				<li ng-repeat="product in compareProductsList">
					{{product.Name}}
					<span ng-click="toggleComparedProduct(product)" class="compare-product-remove-btn">x</span>
				</li>
			</ul>
			<div ng-if="!compareProductsList || compareProductsList.length<1" class="">No products added to compare</div>
		</div>
		<div class="compare-products-link">
			<a target="blank" href="<?= base_url() ?>CompareController/index/<?= $subcategoryName; ?>">Compare</a>
		</div>
		<div class="compare-toggle" id="compareToggleBtn">
			Compare
		</div>
	</div>
	<script>
		$("#compareToggleBtn").click(toggleCompareSection);
		
		function toggleCompareSection(){
			if($(this).hasClass("compare-toggle-active")) {
				$(this).removeClass("compare-toggle-active");
				$(this).parent().removeClass("compare-holder-active");
			}
			else{
				$(this).addClass("compare-toggle-active");
				$(this).parent().addClass("compare-holder-active");
			}
		};
	</script>
	
<script id="ProductFilters.html" type="text/ng-template">
	<div class="panel filters-panel" ng-repeat="filter in filtersList" >
		<div class="panel-header">{{filter.Name}}</div>
		<div class="panel-body">
			<ul class="filters">
				<li ng-repeat="filterValue in filter.details">
					<label>
						<input type="checkbox" ng-checked="appliedFilters[filter.ProductPropertyName].indexOf(filterValue.Value) > -1" 
						ng-click="toggleFiltersSelection(filter.ProductPropertyName, filterValue.Value)" value="{{filterValue.Value}}" />
						{{filterValue.Value}}
					</label>
				</li>
			</ul>
		</div>
	</div>
</script>

	
<script id="ProductListTemplate" type="text/ng-template">
	<div class="row" ng-repeat="productsChunk in productsChunksList">
		<div class="col-md-4" ng-repeat="product in productsChunk track by $index" > 
			<div class="product-tile margin-zero" >
				<span class="bestseller" ng-if="product.IsBestSeller == true">Best seller</span>
				<a class="product-img-holder" href="<?= base_url(); ?>ProductController/Details/{{product.Id}}">
					<img class="img img-responsive" src="<?= base_url() . 'assets/images/products/';?>{{ product.Image }}" alt="" />
				</a>
				<div class="product-info">
					<h3><a href="<?= base_url(); ?>ProductController/Details/{{ product.Id }}">{{ product.Name }}</a></h3>
					<div class="pro-price">
						<span class="normal">{{ product.Price | currency:"Rs. "}}</span>
					</div>
					<div class="star-ratings-sprite"><span title="{{product.Rating}} Rating out of 5" 
						style="width:{{ product.ratingWidth }}%" class="rating"></span></div>
					<div class="clear"></div>
				</div>
				
				<div class="price-details" >
					<ul class="product-hot-properties-list">
						<li ng-repeat="hotProperty in hotProperties" ng-if="product[hotProperty.PropertyName]">{{ product[hotProperty.PropertyName] }}</li>
					</ul>
				</div>
				<label><input ng-disabled="compareProductsList.length > 3" type="checkbox" name="AddToCompare" ng-checked="isAddedToCompare(product.Id)" ng-click="toggleComparedProduct(product)"/> Add to compare</label>
			</div>
		</div>
	</div>
	<div class="shop-pagination">
		<div class="pagination">
			<ul ng-init="page = pagination.pageNumber - 2">
				<li><a  href="javascript:void(0)" ng-click="setPageNumber(pagination.prev)" ><i class="fa fa-chevron-left"></i></a></li>
				<li ng-class="{active:page == pagination.pageNumber}" ng-repeat="page in pagination.pages"><a  ng-click="setPageNumber(page)" href="javascript:void(0)" >{{page}}</a></li>
				<li><a ng-click="setPageNumber(pagination.next)" href="javascript:void(0)"><i class="fa fa-chevron-right"></i></a></li>
			</ul>
		</div>					
	</div>
</script>
	<div class="clear"></div>
</div>
</section>