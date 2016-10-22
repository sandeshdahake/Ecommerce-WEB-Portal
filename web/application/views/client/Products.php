<section>
<?php echo $headingBanner;?>

<div class="clearifix"></div>

<div class="container">
	<div class="row">
		<div class="content">
			<div class="content_top">
				<div class="section-title">
					<div class="sortingSection">
						<select id="sortingSelect" onchange="filterProducts();">
							<option value="priceLowToHigh">Price - Low to High</option>
							<option value="priceHighToLow">Price - High to Low</option>
							<option selected="selected" value="popularity">Popularity</option>
						</select>
					</div>
				</div>
				<div class="clearifix"></div>
			</div>
		</div>
	</div>
	<div clas="row">
	<div class="col-md-3">
		<?= $filtersView; ?>
	</div>
		<div id="ProductsView" class="col-md-9">
			<div id="productsList">
			
			</div>
		</div>
	</div>
	<div class="compare-holder panel">
		<div class="panel-header">
			Compare Products
		</div>
		<div class="panel-body">
			<ul>
				<li>
					Samsung Galaxy j1
					<span class="compare-product-remove-btn">x</span>
				</li>
				<li>Micromaz canvas 2</li>
				<li>Apple iPhone 5</li>
				<li>Apple iPhone 6</li>
			</ul>
			<div class="compare-products-link">
				<a href="<?= base_url() ?>CompareController">Compare</a>
			</div>
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
<script id="ProductListTemplate" type="text/template">
	<% 
	if(productsList.length > 0){
		_.each(productsList, function(product, index){ 
		if(index % 3 == 0 || index == 0){
	%>
	<div class="row">
	<% }%>
		<div class="col-md-4">
			<div class="product-tile margin-zero">
				<% if(product.IsBestSeller == 1) { print("<span class=\"bestseller\">Best seller</span>");} %>
				<a class="product-img-holder" href="<?= base_url(); ?>ProductController/Details/<%= product.Id %>">
					<img class="img img-responsive" src="<?= base_url() . 'assets/images/products/';?><%= product.Image %>" alt="" />
				</a>
				<div class="product-info">
					<h3><a href="<?= base_url(); ?>ProductController/Details/<%= product.Id %>"><%= product.Name %></a></h3>
					<div class="pro-price">
						<span class="normal">Rs. <%= product.Price %></span>
					</div>
					<div class="star-ratings-sprite"><span title="<%= parseFloat(product.Rating).toFixed( 1 ) %> Rating out of 5" 
						style="width:<%= parseInt(product.Rating*20) %>%" class="rating"></span></div>
					<div class="clear"></div>
				</div>
				
				<div class="price-details">
					<ul class="product-hot-properties-list">
						<% _.each(hotProperties, function(property){ 
							if(product[property.PropertyName]){%>
							<li><%= product[property.PropertyName] %></li>
						<% }});%>
					</ul>
				</div>
				<label><input type="checkbox" name="AddToCompare" value="<%= product.Id %>"/>Add to compare</label>
			</div>
		</div>
	<% if(index % 3 == 2){ %>
	</div>
	<% } 
	});
	} %>
	
	<% print("<scr" + "ipt>"); %>
		$("input[name='AddToCompare']").click(function(){
			addToCompare(this.value);
		});
	<% print("</scr" + "ipt>"); %>
</script>

<script>
	function addToCompare(productId){
		console.log('Product Id : ' + productId);
		$.ajax({
            type:'POST',
            url:'<?= base_url();?>SubcategoryController/handleAddToCompare',
            data:{productId:productId},
			dataType :'JSON',
			success:function(data){
				console.log(data);
			}
        });
	}
	
	function filterProducts(event){
		var filters = {};
		$.each(document.forms['product_filters_form'], function(index, element){
			if(element && element.type == 'checkbox'){
				if(element.checked){
					if(!filters.hasOwnProperty(element.name)){
						filters[element.name] = [];
					}
					filters[element.name].push(element.value);
				}
			}
		});
		var filtersObj = {};
		for(key in filters){
			if(filters[key].length > 0){
				filtersObj[key] = filters[key].join("|");
			}
		}
		var sortBy = $("#sortingSelect").val();
		if(!sortBy){
			sortBy = "popularity";
		}
		getProducts(filtersObj, sortBy);
	}
	
	$("#product_filters_form").change(filterProducts);
	
	$("#sortingSelect").change(filterProducts);
	
	function getProducts(filtersObj, sortBy){
		var subcategory = "<?= $subcategoryName; ?>";
		// request products
		$.ajax({
            type:'POST',
            url:'<?= base_url();?>SubcategoryController/products/'+ subcategory,
            data:{data:filtersObj, sortBy: sortBy},
			dataType :'JSON',
			success:function(data){
				console.log(JSON.stringify(data));
				if(data){
					var template = _.template($("#ProductListTemplate").html());
					$("#productsList").html(template({ productsList : data.Products , hotProperties:data.hotProperties}));
				}
				else{
					$("#productsList").html('</p>No Products foound</p>');
				}
            }
        });
	}
	
	$(document).ready( function(){
		filterProducts();
	});
</script>
	<div class="clear"></div>
</div>
</section>