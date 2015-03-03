
 <form  class="contact">
    <fieldset class="contact-inner">
    	<div class="error_message" style="display:none;"></div>
      <p class="normal">Fill in your contact details below:-</p>
      <p class="contact-input">
      	<?= form_input('name', '','class="required 115" placeholder="Your Name…" autofocus'); ?> 
      </p>
	  	<p class="contact-input">
	  		<?= form_input('mobile', '','class="required 117 phone_number" placeholder="Mobile No." autofocus'); ?>  
      </p>
      <p class="contact-input">
      	<?= form_input('ic', '','class="required 116 num_only" placeholder="Identity Card No." autofocus'); ?>   
      </p>
      <p class="contact-input">
      	<?= form_input('email', '','class="required 101 105" placeholder="Your Email Address…" autofocus'); ?>   
      </p>
      <p class="contact-input">
        <label for="select" class="select">
          <?= form_dropdown('state',array("" => "Choose State…")+$this->config->item('state'),'','class="required 113" id="select"' ) ?>
        </label>
      </p>
      <p class="normal">All information collected is solely for contest entry purposes and KOSE MALAYSIA will not disclose your personal particulars to any third parties.</p>
      <p class="normal" style="border-top: 1px solid #ccc; padding-top:10px; margin-top:10px;">
      	<input type="checkbox" name="agreement" class="required 121" /> I agree to be contacted by KOSE Malaysia if necessary.
      </p>
      <p class="normal">
	  	<input type="checkbox" name="tnc" class="required 122" /> I have read and agreed to the Terms & Conditions.
      </p>
      
      <p class="contact-submit" style="padding-top:10px;">
     		<?= $this->config->item('img_loading2') ?> <input type="submit" id="submitformbutton" value="Next">
      </p>
    </fieldset>
  </form>
<script type="text/javascript" >	

var queryString  = "<?= $this->config->item('domain') ?>/<?= $this->name ?>/";
$('#submitformbutton').click(function() {
	showLoading();
	var form_data = $('form').serialize();
	resetError();
	$.post(queryString+"createContestant/" , form_data, function(data) {  
		var obj = jQuery.parseJSON(data); 
		hideLoading();
		if(obj.status == "error"){
			$(".error_message").show();
			var eCode = obj.error_code ;
			$.each(eCode, function( index ,code) {
			  $("."+code).css('outline','1px red solid'); 
			  $("."+code).css('border','1px red solid'); 
			});
			
			var eData = obj.data ;
			 $(".error_message").html("<p> Please check for following error(s):</p>");
			$.each(eData, function( index ,errData) {
			  $(".error_message").append('<p> - '+errData+'</p>');
			});
			
		}else{
			setTimeout(function() {location.href=window.location.href= "<?= $this->config->item('domain') ?>/tac/index/"+obj.data;},500);	 
		}		
				
	});
	return false; 
}); 

</script>