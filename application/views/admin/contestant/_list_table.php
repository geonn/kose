	<table class="bordered">
	<tbody>
		<tr> 
		
			<th><a href="javascript:void(0)" onclick="sorting('name','<?= $new_sort ?>');">Name <span id="name_sortimg"></span></a></th>
			<th><a href="javascript:void(0)" onclick="sorting('ic','<?= $new_sort ?>');">I/C <span id="ic_sortimg"></span></a></th>
			<th><a href="javascript:void(0)" onclick="sorting('mobile','<?= $new_sort ?>');">Mobile Number  <span id="mobile_sortimg"></span></a></th>
			<th><a href="javascript:void(0)" onclick="sorting('email','<?= $new_sort ?>');">Email<span id="email_sortimg"></span></a></th>
			<th><a href="javascript:void(0)" onclick="sorting('state','<?= $new_sort ?>');">State<span id="state_sortimg"></span></a></th>
			<th><a href="javascript:void(0)" onclick="sorting('updated','<?= $new_sort ?>');">Played Date<span id="updated_sortimg"></span></a></th>
			<th>Slogan</th>
		</tr>
		
	<?php if(!empty($results)){
		foreach ($results as $row):
		 ?>		
    	<tr>
    	
			<td><strong><font color="green"><?= $row['name'];?></font></strong></td>
			<td><?= $row['ic'];?></td>	
			<td><?= $row['mobile'];?></td>	
			<td><?= $row['email'];?></td>	
			<td><?= match($row['state'], $this->config->item('state'));?></td>	
			<td><?= date_convert($row['created'], 'full');?></td>
			<td><?= $row['slogan'] ?></td>																
		</tr>
	<?php endforeach; ?>		
	
		<?php 	}else{ ?>
			<tr><td colspan="7" ><div align='center'>No result found</div></td></tr>
		<?php  } ?>		
	</tbody>	
</table>	

<div class='pagination'>
	<?= $this->pagination->create_links($this->uri->segment(4)); ?>	
</div>
<br/><br/><br/>