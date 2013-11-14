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
<title>Forget Password</title>

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
        
        #recovery{ 
background: rgb(114,135,160); /* Old browsers */
position:relative;
padding: 20px 25px 15px;
width:45em;
margin:0 auto;
margin-top:3%;
padding-bottom:2em;  
}
#recovery input[type="text"] {
	
	 width: 100%;
    height: 40px;
    position:relative;
    margin-top: 7px;
    font-size: 14px;
    color: #444;
    outline: none;
    border: 1px solid rgba(0, 0, 0, .49);
    padding-left: 1em;
    
    
    
	
}

#recovery label{
display: block;
margin: 0 auto 1.5em auto;
width:300px;
 
}
.labellogin {

margin: 0 0 .5em;
display: block;
color: #fff;
-moz-user-select: none;
user-select: none;
 font: 16px 'LeagueGothicRegular';
 
}

#recovery input[type="submit"] {
    width: auto;
    height: 2.4em;
    margin-top: 7px;
    color: #fff;
    font-size: 15px;
    font-weight: bold;
    text-shadow: 0px -1px 0px #5b6ddc;
    outline: none;
    border: 1px solid rgba(0, 0, 0, .49);
    
    background-color: #5466da;
    background-image: -webkit-linear-gradient(bottom, #5466da 0%, #768ee4 100%);
    background-image: -moz-linear-gradient(bottom, #5466da 0%, #768ee4 100%);
    background-image: -o-linear-gradient(bottom, #5466da 0%, #768ee4 100%);
    background-image: -ms-linear-gradient(bottom, #5466da 0%, #768ee4 100%);
    background-image: linear-gradient(bottom, #5466da 0%, #768ee4 100%);
    -webkit-box-shadow: inset 0px 1px 0px #9ab1ec;
      cursor: pointer;
    -webkit-transition: all .1s ease-in-out;
    -moz-transition: all .1s ease-in-out;
    -o-transition: all .1s ease-in-out;
    -ms-transition: all .1s ease-in-out;
    transition: all .1s ease-in-out;
}
#recovery input[type="submit"]:hover {
    background-color: #5f73e9;
    background-image: -webkit-linear-gradient(bottom, #5f73e9 0%, #859bef 100%);
    background-image: -moz-linear-gradient(bottom, #5f73e9 0%, #859bef 100%);
    background-image: -o-linear-gradient(bottom, #5f73e9 0%, #859bef 100%);
    background-image: -ms-linear-gradient(bottom, #5f73e9 0%, #859bef 100%);
    background-image: linear-gradient(bottom, #5f73e9 0%, #859bef 100%);
    -webkit-box-shadow: inset 0px 1px 0px #aab9f4;
    box-shadow: inset 0px 1px 0px #aab9f4;
    margin-top: 10px;
}
#recovery input[type="submit"]:active ,#send:active{
    background-color: #7588e1;
    background-image: -webkit-linear-gradient(bottom, #7588e1 0%, #7184df 100%);
    background-image: -moz-linear-gradient(bottom, #7588e1 0%, #7184df 100%);
    background-image: -o-linear-gradient(bottom, #7588e1 0%, #7184df 100%);
    background-image: -ms-linear-gradient(bottom, #7588e1 0%, #7184df 100%);
    background-image: linear-gradient(bottom, #7588e1 0%, #7184df 100%);
    -webkit-box-shadow: inset 0px 1px 0px #93a9e9;
    box-shadow: inset 0px 1px 0px #93a9e9;
}

    </style>
<script type="text/javascript">
	$(document).ready(function() {
		
			$('.errorlogin').fadeOut(10000, function() {
    // Animation complete.
  });
  
  
  	$("#home").click(function(){
		window.location="<?php echo base_url();?>";
		});
	});

</script>
</head>

<body>

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
	
	

<form action="<?php echo base_url().'User_Management/password_recovery'?>" method="post" id="login">
 <?php  

if (isset($popup)) {
	
	echo	'<p class="errorlogin">An Error has occured, Please Enter an Existing user.</p>';
}
unset($popup);
 ?> 	
<div id="recovery">
	 
	 	<h2 style="letter-spacing: -1px; font-weight: bold;	color: #fff; width: auto; height: auto; display: block; margin-top:2em; font: 2.4em 'LeagueGothicRegular';">Forgot Password</h2>

<div style="font-size: 15px;padding-bottom: 0.6em">
	Please enter your Email Address below to reset your password.
</div>

<label class="labellogin">
Email
<input type="text" name="username" id="username" value="" placeholder="me@domain.com" required="required">
</label>
<label class="labellogin">

 <input type="submit" class="button " name="register" id="register" value="Submit" style="margin-left:100px;">
 <input type="submit" class="button " name="home" id="home" value="home" value="Submit" style="margin-left:100px;">
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
