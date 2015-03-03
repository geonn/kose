<form class="contact">
<h4>Verify TAC</h4>
<div class="error_message" style="display:none;"></div>
  <fieldset class="contact-inner">
    <p class="contact-input">
    	Name: <?= $info['name'] ?><br/>
      Mobile No.: <?= $info['mobile'] ?>
    </p>
    <p class="contact-input" style="margin-top:10px;">
    	<?= form_input('tac', '','class="required 123 124 num_only" placeholder="TAC No." autofocus style="width:120px; float:left;"'); ?>
      <input type="button" id="requestformbutton" style="width:auto; float:left; margin-left:10px;" class="button" value="Request For TAC"/>
    </p>
    <p class="contact-submit" style="padding-top:10px;">
      <?= $this->config->item('img_loading2') ?> <input type="submit" id="submitformbutton" value="Verify">
    </p>
  </fieldset>
</form>
<script type="text/javascript" >	
var queryString  = "<?= $this->config->item('domain') ?>/<?= $this->name ?>/";

$('#requestformbutton').click(function() {
	$.post(queryString+"requestTac/<?= $key?>", function(data) {   
		var obj = jQuery.parseJSON(data); 
		if(obj.status == "success"){
			alert("TAC number sent to your mobile.");
		}
	});
});

$('#submitformbutton').click(function() {
	showLoading();
	var form_data = $('form').serialize();
	resetError();  
	$.post(queryString+"submitTac/<?= $key?>/" , form_data, function(data) { 
 		hideLoading();
		var obj = jQuery.parseJSON(data); 
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
			location.href=window.location.href= "<?= $this->config->item('domain') ?>/slogan/index/<?= $key?>";
		}		
				
	});
	return false;
}); 

</script>
