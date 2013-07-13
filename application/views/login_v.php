

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<style>
	
	@-webkit-keyframes greenPulse {
from { background-color: #749a02; -webkit-box-shadow: 0 0 9px #333; }
50% { background-color: #91bd09; -webkit-box-shadow: 0 0 18px #EBDDE2; }
to { background-color: #749a02; -webkit-box-shadow: 0 0 9px #333; }
}
#top-panel {
	overflow: hidden;
	border-bottom: 2px solid #C0C0C0;
	width: 100%;
	height: 130px;
	background: white;
	z-index: 5;
	min-width: 980px;
	margin-top: 1%;
}
	
</style>	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HCMP | Login</title>

 <script src="<?php echo base_url().'Scripts/jquery.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/jquery-ui.js'?>" type="text/javascript"></script>
<link rel="icon" href="<?php echo base_url().'Images/coat_of_arms.png'?>" type="image/x-icon" />
<link href="<?php echo base_url().'CSS/style.css'?>" type="text/css" rel="stylesheet"/> 
<link href="<?php echo base_url().'CSS/jquery-ui.css'?>" type="text/css" rel="stylesheet"/>
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
<style>
       
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
<script type="text/javascript">
	$(document).ready(function() {
		
			$('.successreset').fadeOut(5000, function() {
    // Animation complete.
  });
$('.errorlogin').fadeOut(5000, function() {
    // Animation complete.
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

				<div id="Banner">
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Ministry of Health</span>
					<span style="display: block; font-size: 12px;">Health Commodities Management Platform</span>	
				</div>
				<div class="banner_text" style="float: left"><?php //echo $banner_text;?></div>
				
	</div>
	
	

<?php echo validation_errors('<p class="errorlogin">','</p>'); 

if (isset($popup)) {
	
	echo	'<p class="successreset">Successful reset. Please check your email.</p>';
}
unset($popup);
 ?>
 <form action="<?php echo base_url().'user_management/submit'?>" method="post" id="login">
  	
<div id="slick-login">
	 <section class="short_title" >
	 	<legend class="login_text">Sign in</legend>

</section>

<label class="labellogin">
Username
<input type="text" name="username" id="username" value="" placeholder="me@domain.com">
</label>
<label class="labellogin">
Password
<input type="password" name="password" id="password" placeholder="password">
</label>
 <input type="submit" class="button " name="register" id="register" value="Log in" style="margin-left:100px;">
 <a class="Homelink" href="<?php echo base_url().'user_management/forget_pass'?>" id="modalbox">Can't access your account ?</a>
</form>
<?php 

		echo form_close();
		?>
</div>

    <div class="footer">
	Government of Kenya &copy; <?php echo date('Y');?>. All Rights Reserved
	
	</div>
    
</body>
</html>
