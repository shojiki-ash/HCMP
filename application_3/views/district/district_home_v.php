
<div id="main_content">
	<div id="left_content">
		<fieldset>
			<legend>Actions</legend>

		<div class="activity order">
		<a href="<?php echo site_url('order_approval/district_orders');?>">	<h2>View District Orders</h2>		</a>
		</div>
		<div class="activity users" id="demo">
		<a href="<?php echo site_url('user_management/dist_manage');?>"><h2>User Management</h2></a>
		</div>
		
		<div class="activity reports">
	    <a href="#">	<h2>District Reports</h2>	</a>
		</div>
				
		</fieldset>
	</div>
	
	<div id="right_content">
		<fieldset>
			<legend>Notifications</legend>
			<?php if($pending_orders>0):?>
		<div class="message warning">
			<h2>Make order</h2>
			<p>
				<a href="<?php 
				echo site_url('order_approval/district_orders');?>" <a class="link"><?php echo $pending_orders.' Orders Pending approval'?> </a>
			</p>
		</div>
		<?php endif; ?>
		</fieldset>
	</div>
	<!--<div id="full_width">
		<div class="message graph"> 
			<h2>Average Order Satisfaction %</h2>
			<p>
				
			</p>
			<div id="order_satisfaction" class="graph_container"></div>
			
		</div>
	</div>-->
</div>
