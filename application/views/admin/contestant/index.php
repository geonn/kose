<script>
	var page         = "<?= $page ?>";
	var searchstring = "<?= $search ?>";
	var sortby       = "<?= $sortby ?>";
	var state       = "<?= $state ?>";
	var queryString  = "<?= $this->config->item('admin_url') ?>/<?= $this->name ?>";
	var queryParam   = page+"/"+sortby+"?q="+searchstring+"&state="+state;
  	get_list(queryParam);	 
  
	function get_list(queryParam){ 
		$.get(queryString+'/get_list/'+queryParam, function(data) {
			jQuery('#loading').hide();
			jQuery('#q').val(searchstring);
			jQuery('#state').val(state);
		  	jQuery('#the_list').html(data);
		  	
		  	if(sortby != ""){
		  		splitinfo = sortby.split("-");
		  		if(splitinfo[1] == '1'){
		  			jQuery('#'+splitinfo[0]+'_sortimg').html('<?= $this->config->item("icon_up") ?>');
		  		}else{
		  			jQuery('#'+splitinfo[0]+'_sortimg').html('<?= $this->config->item("icon_down") ?>');
		  		}	  		
		  	}
			});
	}
	
	function sorting(field,sort){
			sortby =field+"-"+sort;
			url= page+"/"+sortby+"?q="+searchstring+"&state="+state;
			get_list(url);
	}
	
	function downloadContestantList(){
		window.location.href = queryString + "/downloadContestantList/"+queryParam;
		return false;
	}
</script>
<div class="container_header">
	<div class="header_title"><a class="separator" href="<?= $this->config->item('domain') ?>">Home</a> <?= ucwords($this->name) ?> List</div>
    <div class='search_panel' style="float: left;">
        <div style="float:left; padding-left:10px;">
            <form action="<?= $this->config->item('admin_url') ?>/<?= $this->name ?>/index" method="get">	
            	<?= form_dropdown('state', array(""=>"--All State--")+$this->config->item('state'), set_value('state',isset($state) ? $state : '' ) ); ?>					
              <input name="q" id="q" type="text" value="<?= set_value('q',''); ?>" placeholder="Search name,ic,mobile,email,slogan ..." class="mystyles_textbox" style="width:200px;">
              <button type="submit" class="blue_button " value="Submit " >Filter</button>  
            </form>
        </div>
        <button type="button" value="Export" style="margin: 2px 15px;" onClick='return downloadContestantList()'>Export List</button>  
        <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
</div>
<?= $template['partials']['message']; ?>
<div id="submenu">
	<ul>
    	<li class="li-selected"><a href="<?php echo $this->config->item('admin_url').'/'.$this->name.'/index'?>"><?= ucwords($this->name) ?> List</a></li>
      <li><a href="<?php echo $this->config->item('admin_url').'/'.$this->name.'/slogan'?>">Slogan Report</a></li> 
      <li><a href="<?php echo $this->config->item('admin_url').'/'.$this->name.'/luckyDraw'?>">Lucky Draw Report</a></li> 
	</ul>
</div>
<div id="loading" name="loading" align='center'><br/><br/><br/><?= $this->config->item("img_loading") ?><br/><br/></div>
<div id="the_list"></div>

