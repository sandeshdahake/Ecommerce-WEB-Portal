<!-- subscribe-area start -->
<div class="subscribe-area">
	<div class="container">
		<div class="subscribe-title">
			<h3><span>Subscribe</span>to our newsletter</h3>
			<p>Subscribe to the Expert mailing list to receive updates on new arrivals, special offers and other discount information.</p>
			<form onsubmit="addToSubscribe(event)">
				<div class="subscribe-form">
					<input id="subscribeEmail" type="text" placeholder="Your Email........." required/>
					<div id="subscribeValidationMessage" class="message error">Please enter valid Email address.</div>
					<button>subscribe</button>
				</div>
			</form>
		</div>				
	</div>
</div>

<script>
	function addToSubscribe(e){
		e.preventDefault();
		$("#subscribeValidationMessage").hide();
		var email = $("#subscribeEmail").val();
		if(validateEmail(email)){
			email = encodeURIComponent(email);
			
			$.ajax({
				url:"<?= base_url()?>HomeController/addToSubscribe/" +email ,
				success:function(resonseMessage){
					$("#subscribeValidationMessage").removeClass('error');
					$("#subscribeValidationMessage").addClass('success');
					$("#subscribeValidationMessage").text(resonseMessage);
					$("#subscribeValidationMessage").show();
				}
			});
		}
		else{
			$("#subscribeValidationMessage").removeClass('success');
			$("#subscribeValidationMessage").addClass('error');
			$("#subscribeValidationMessage").text('Please enter valid Email address.');
			$("#subscribeValidationMessage").show();
		}
	}
		
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
</script>
<!-- subscribe-area end -->