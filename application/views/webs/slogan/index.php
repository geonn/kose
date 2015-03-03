 <form   class="contact">
 	<h4>SEKKISEI helps keep the skin moist, soft and translucent.</h4>
 	<div class="error_message" style="display:none;"></div>
    <fieldset class="contact-inner">
      <p class="normal" style="padding-bottom:10px;">Tell us in your own words how SEKKISEI can help the modern-day Cinderellas (in 50 words or less.)</p>
      <p class="contact-input">
        <textarea name="slogan" class="required 118 119" placeholder="Your Slogan…"></textarea>
      </p>
      <h4>Terms and Conditions</h4>
      <ul>
      	<li>All submissions will stand a chance to win the grand prize of a family trip to Tokyo and daily prizes as well.</li>
        <li>Winners of the Grand Prize will only be announced at the end of the contest.</li>
        <li>Daily prizes are randomly awarded, hence not every entry will be guaranteed a prize.</li>
        <li>Participants are only allowed to submit a maximum of 3 entries.</li>
        <li>Winners will have to redeem their prizes at KOSE stores/counters.</li>
        <li>Winners will be contacted to arrange for the redemption of prizes.</li>
      </ul>
      <p class="contact-submit" style="padding-top:10px;">
       <?= $this->config->item('img_loading2') ?> <input type="submit" id="submitformbutton" value="Submit">
      </p>
    </fieldset>
  </form>
  <script type="text/javascript" >	
		var queryString  = "<?= $this->config->item('domain') ?>/<?= $this->name ?>/";
		$('#submitformbutton').click(function() {
			showLoading();
			var form_data = $('form').serialize();
			resetError();
			$.post(queryString+"createSlogan/<?= $key?>" , form_data, function(data) {  
	 			hideLoading();
				var obj = jQuery.parseJSON(data); 
				if(obj.status == "error"){
					$(".error_message").show();
					var eCode = obj.error_code ;
					$.each(eCode, function( index ,code) { 
					  $("."+code).css('border','1px red solid'); 
					});
					
					var eData = obj.data ;
					 $(".error_message").html("<p> Please check for following error(s):</p>");
					$.each(eData, function( index ,errData) {
					  $(".error_message").append('<p> - '+errData+'</p>');
					});
					
				}else{
					location.href=window.location.href= "<?= $this->config->item('domain') ?>/luckydraw/index/<?= $key?>";
				}		
						
			});
			return false; 
		}); 
	
	</script>