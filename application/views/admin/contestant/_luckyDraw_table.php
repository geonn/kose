	<table class="bordered">
	<tbody>
		<tr>  
			<th>Name</th>
			<th>I/C</th>
			<th>Mobile Number</th>
			<th>Email</th>
			<th>State</th>
			<th>Prize</th>
			<th>Date Won</th>
		</tr>
		
	<?php if(!empty($results)){
		foreach ($results as $row):
		 ?>		
    	<tr>
    	
			<td><strong><font color="green"><?= $row['name'];?></font></strong></td>
			<td><?= $row['ic'];?></td>	
			<td><?= $row['mobile'];?></td>	
			<td><?= $row['email'];?></td>	
			<td><?= match($row['state'],$this->config->item('state')) ?></td>	
			<td><?= $row['prize'];?></td>			
			<td><?= date_convert($row['created'],'full') ?></td>															
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