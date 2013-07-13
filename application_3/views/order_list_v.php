<?php if(count($dispatched)>0) :?>
		<table class="data-table">
			<tr>
				<th><strong>Facility Order No </strong></th>
				<th><strong>KEMSA Order No </strong></th>
				<th><strong>Order Total Ksh</strong></th>
				<th><strong>Date Ordered</strong></th> 
				<th><strong>Date Reviewed</strong></th> 
				<th><strong>Date Received(kemsa)</strong></th>
				<th><strong>Date Dispatched</strong></th> 
				<th>Action</th>
			</tr>
			<?php foreach($dispatched as $d):?>
			<tr>
				<td><?php echo $d->id;?></td>
				<td><?php echo $d->kemsaOrderid;?></td>
				<td><?php echo number_format($d->orderTotal, 2, '.', ',');?></td>
				<td><?php 
		$datead= $d->orderDate;
		$fechaad = new DateTime($datead);
        $dated= $fechaad->format(' d  M Y');
		echo $dated;?></td> 
				<td><?php 
		if($d->approvalDate!=NULL){
		$date_approval = new DateTime($d->approvalDate);
        $dateb_approval= $date_approval->format(' d  M Y');
		echo $dateb_approval;}
		?></td> 
		<td><?php echo $dateb_approval; ?></td>
				<td><?php 
		$datebd= $d->dispatchDate;
		if($d->dispatchDate!=NULL){
		$fechabd = new DateTime($datebd);
		$today=new DateTime();
        $datebd= $fechabd->format(' d  M Y');
		echo $datebd;}?></td>
				<td><a href="<?php echo site_url('order_management/moh_order_details/'.$d->id.'/'.$d->kemsaOrderid)?>"class="link">View</a>|<a href="<?php echo site_url('stock_management/new_update/'.$d->id.'/'.$d->kemsaOrderid)?>" class="link">Update</a?</a></td>
			</tr>
	<?php
endforeach;
	?>
			
		</table>
		<?php 
else :
	echo '<p id="notification">No Records Found </p>';
endif; ?>