<style>
			.user{
	background : none;
	border : none;
	text-align: center;
	}
			
			 .form_settings { 
  margin: 15px 0 0 0;
  font-size: 14px;
  font-family: 'trebuchet MS', 'Lucida sans', Arial;
}

.form_settings p { 
  padding: 0 0 4px 0;
}
			 
			 .form_settings span { 
  float: left; 
  width: 20%; 
  text-align: left;
}
  
.form_settings input, .form_settings textarea , .form_settings select { 
  padding: 5px; 
  width: 50%; 
  font: 100% arial; 
  border: 1px solid #D5D5D5; 
  color: #47433F;
  border-radius: 7px 7px 7px 7px;
  -moz-border-radius: 7px 7px 7px 7px;
  -webkit-border: 7px 7px 7px 7px;  
}

.super{
vertical-align: super;
padding-left: 0.3em;
color: #B70000;

			}
			
		</style>  

<?php $attributes = array( 'name' => 'myform', 'id'=>'formEditData','class'=>'form_settings', 'title'=>'User Details');
	 echo form_open('user_management/edit_user_profile',$attributes); ?>

      <p><span>First Name</span><input type="text" name="f_name" id="f_name" required="required" value="<?php echo $user_data[0]['fname'] ?>" /><b class="super">*</b></p> 
	
      
        <p><span>Other Name</span><input type="text" name="o_name" id="o_name" value="<?php echo $user_data[0]['lname'] ?>" /><b class="super">*</b></p>
        <p><span>Email</span><input type="text" name="email" id="email" size="50" required="required" placeholder="someone@mail.com" value="<?php echo $user_data[0]['email'] ?>" /><b class="super">*</b></p>
           <p> <label id="feedback"></label><input type="hidden" /></p>
        
	      <p><span>User Name</span><input class="user" type="text" name="user_name" value="<?php echo $user_data[0]['email'] ?>" id="user_name" readonly="readonly"/> </p>

        <p><span>Phone No</span><input type="text" name="phone_no"  id="phone_no" required="required" value="<?php echo $user_data[0]['telephone'] ?>" placeholder="254...."/> <b class="super">*</b></p>
</form>
