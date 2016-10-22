<?php if(isset($_SESSION['user']) && $_SESSION['user']!=null){ ?>
<div class="col-md-12">
<div class="your-review">
	<h3>How Do You Rate This Product?</h3>
	<p>Write Your Own Review?</p>
	
	<form class="review-form" id="reviewForm" name="reviewForm">
		<fieldset class="rating-input">
			<input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Best"></label>
			<input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Good"></label>
			<input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Not bad"></label>
			<input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Needs improvement"></label>
			<input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Bad"></label>
		</fieldset>
		<div class="form-group">
			<label>Title<span class="red">*</span></label>
			<input type="text" required="required" name="reviewTitle"/>
		</div>
							
		<div class="form-group">
			<label>Review<span class="red">*</span></label>
			<textarea rows="10" required="required" width="90%" name="reviewDescription"></textarea>
		</div>
		<div>
			<input type="submit" value="SUBMIT REVIEW">
		</div>
	</form>
	<script>
		$("#reviewForm").submit(function(e){
			e.preventDefault();
			var form = this;
			var review = {};
			$.each(this, function(index, element){
				if(element.nodeName == 'INPUT'){
					if(element.type == 'radio'){
						if(element.checked){
							review[element.name] = element.value;
						}
					}
					else if(element.type == 'text'){
						review[element.name] = element.value;
					}
				}
				else if(element.nodeName == 'TEXTAREA'){
					review[element.name] = element.value;
				}
				
			});
			review["ProductId"] = "<?= $productId; ?>";
			
			$.ajax({
				type:"POST",
				url:"<?= base_url(); ?>ProductController/createReviewRec",
				data:{data:review},
				success:function(data){
					window.location.reload();
					console.log(data);
					//form.reset();
				}
			});
			
		});
	
	</script>
</div>
</div>
<?php 
} else{
?>
<div class="pro-button-top"><a href="javascript:void(0)" onclick="document.getElementById('loginTemplate').style.display = 'block'" >Login to review</a></div>
<?php
}
?>
<!--- show existing reviews -->
<?php
	if(count($reviewsList) > 0){
		foreach($reviewsList as $review){
?>
	<div class="col-md-12">
		<div class="review-tile">
			<div class="col-md-3">
				<div class="reviewer">
					<div class="reviewer-name">
						<?= $review->FirstName . ' ' . $review->LastName; ?>
					</div>
					<div class="review-date">
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="item-review">
					<div class="review-title">
						<?= $review->ReviewTitle ?>
					</div>
					<div class="review-description">
						<?= $review->ReviewDescription; ?>
					</div>
				</div>
			</div>
		</div>	
	</div>
<?php
		}
	} else{
?>
<p>No reviews</p>

<?php } ?>
