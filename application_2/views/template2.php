<?php
if (!$this -> session -> userdata('user_id')) {
	redirect("user_management/login");
}
if (!isset($link)) {
	$link = null;
}
if (!isset($quick_link)) {
	$quick_link = null;
}
$access_level = $this -> session -> userdata('user_indicator');
$user_is_facility = false;
$user_is_moh = false;

if ($access_level == "facility") {
	$user_is_facility = true;
}
if ($access_level == "moh") {
	$user_is_moh = true;

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<link href="<?php echo base_url().'CSS/style.css'?>" type="text/css" rel="stylesheet"/> 
<link href="<?php echo base_url().'CSS/jquery-ui.css'?>" type="text/css" rel="stylesheet"/> 
<script src="<?php echo base_url().'Scripts/jquery.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/jquery-ui.js'?>" type="text/javascript"></script>
 

<?php
if (isset($script_urls)) {
	foreach ($script_urls as $script_url) {
		echo "<script src=\"" . $script_url . "\" type=\"text/javascript\"></script>";
	}
}
?>

<?php
if (isset($scripts)) {
	foreach ($scripts as $script) {
		echo "<script src=\"" . base_url() . "Scripts/" . $script . "\" type=\"text/javascript\"></script>";
	}
}
?>


 
<?php
if (isset($styles)) {
	foreach ($styles as $style) {
		echo "<link href=\"" . base_url() . "CSS/" . $style . "\" type=\"text/css\" rel=\"stylesheet\"/>";
	}
}
?>  
<script type="text/javascript">
	$(document).ready(function() {
		$("#my_profile_link").click(function(){
			$("#logout_section").css("display","block");
		});

	});

</script>
</head>

<body>
<div id="wrapper">
	<div id="top-panel" style="margin:0px;">

		<div class="logo">
			<a class="logo" href="<?php echo base_url();?>" ></a> 
</div>

				<div id="system_title">
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Public Health and Sanitation/Ministry of Medical Services</span>
					<span style="display: block; font-size: 12px;">Health Commodities Management Platform</span>
					
				</div>
				<div><div class="banner_text" style="float: left"><?php echo $banner_text;?></div>
				
	</div>
	<?php if($banner_text=="New Order"):?>
				<div style="display: block; margin-left: 40%;font-family: Helvetica, Arial, sans-serif;">
					
			<span><b> Total Order Value </b><b id="t" >  0</b></span>
			<span style="display: block; font-size: 12px;"><b> Drawing Rights Available Balance  </b><b id="drawing">6000000</b></span>
		           
	</div>
	<?php endif;?>
 <div id="top_menu"> 

 	<?php
	//Code to loop through all the menus available to this user!
	//Fet the current domain
	$menus = $this -> session -> userdata('menu_items');
	$current = $this -> router -> class;
	$counter = 0;
?>
 	<a href="<?php echo base_url();?>home_controller" class="top_menu_link  first_link <?php
	if ($current == "home_controller") {echo " top_menu_active ";
	}
?>">Home </a>
<?php
if($user_is_facility){
?>
 	<a href="<?php echo base_url();?>order_management" class="top_menu_link <?php
	if ($current == "order_management") {echo " top_menu_active ";
	}
?>">My Orders </a>

 	<a href="<?php echo base_url();?>report_management" class="top_menu_link <?php
	if ($current == "report_management") {echo " top_menu_active ";
	}
?>">Reports </a>

 <?php
}
?>

<a ref="#" class="top_menu_link" id="my_profile_link"><?php echo $this -> session -> userdata('full_name');?></a>
<div id="logout_section" style="position:absolute; right:0; top:50px; background-color: white; border:1px solid #00B831; padding:5px; display:none;">
	<a  class="link" href="<?php echo base_url();?>user_management/login">Logout</a>
</div>
 </div>

</div>

<div id="inner_wrapper"> 


<div id="main_wrapper"> 
 
<?php $this -> load -> view($content_view);?>
 
 
 
<!-- end inner wrapper --></div>
  <!--End Wrapper div--></div>
    <div id="bottom_ribbon">
        <div id="footer">
 <?php $this -> load -> view("footer_v");?>
    </div>
    </div>
</body>
</html>
