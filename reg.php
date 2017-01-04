<?php
/**
 * Plugin Name: Register
 * Description: To create registration-form	
 * Version: 1.0.0
 * Author: Prakash Ranjan Kumar
 * Author URI: http://www.kumarpc.herobo.com
 * */
 
  function add_roles_on_plugin_activation() 
  {
     // check role in array & insert role
	 global $wp_roles;
     $roles = $wp_roles->get_names();
     if (!in_array( 'test',$roles )) 
     {
	     add_role('test','hello1',
                     array(
                             'read'         => true,  // true allows this capability
                             'edit_posts'   => true,
                             'delete_posts' => false, // Use false to explicitly deny
                          )
                );
     }
	 
}
   register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );
//creating menu
add_action("admin_menu","create_menu");
	
	function create_menu() 
	{
			add_object_page(
							 'Register',
							 'Register',
							 'install_plugins',
							 'register',
							 'register'
						    );
    
    	    
	}
	//creating menu
	
	//This function is used to create registration-form	
	
add_shortcode('Registration-Form', 'registration_shortcode');
function registration_shortcode()
{	

	$registration_caller = $_POST['registration_caller'];

	if($registration_caller == "self")
    {
    	$reg_name = strip_tags(addslashes(trim($_POST['reg_name'])));
    	$reg_mobile_no = strip_tags(addslashes(trim($_POST['reg_mobile_no'])));
    	$reg_email = strip_tags(addslashes(trim($_POST['reg_email'])));
		$reg_pass = strip_tags(addslashes(trim($_POST['reg_pass'])));
		//$reg_skill = strip_tags(addslashes(trim($_POST['reg_skill'])));
		
		$errors = array();
    	
    	if(empty($reg_name)) $errors['reg_name'] = "Empty";
    	if(empty($reg_mobile_no)) $errors['reg_mobile_no'] = "Empty";
        if(empty($reg_email)) $errors['reg_email'] = "Empty";
		if(empty($reg_pass)) $errors['reg_pass'] = "Empty";
		//if(empty($reg_skill)) $errors['reg_skill'] = "Empty";
		if(empty($errors))
		{
		   $userdata = array(
                               'display_name' => $reg_name,
							   'user_login' => $reg_name,
                               'mobile_no' => $reg_mobile_no,
	                           'user_email' => $reg_email,
                               'user_pass' => $reg_pass,
	                           'date_time' => current_time('mysql', 1)	
                            );
                            $user_id = wp_insert_user( $userdata ) ;
		}
	}
	   //On success
       if ( is_wp_error( $user_id ) ) 
       {
          $error_string = $user_id->get_error_message();
          echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
       }
 //echo get_permalink( $post->ID );
//This function is used to create registration-form	
?>
	<section class="container">
	<div class="row">
    	<div class="col-md-6">
        	 <form class="form-horizontal" method="post" action="<?php get_permalink();?>">
             	 <div class="form-group">
                    <label class="control-label col-md-6" for="reg_name">Name:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="reg_name" id="reg_name" placeholder="Enter Your Name">
                    	<?php echo $errors['reg_name']; ?>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-6" for="reg_mobile_no">Mobile Number:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="reg_mobile_no" id="reg_mobile_no" placeholder="Enter Your Mobile Number">
                    	<?php echo $errors['reg_mobile_no']; ?>
                    </div>
                </div>
             
             	 <div class="form-group">
                    <label class="control-label col-md-6" for="reg_email">Email:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="reg_email" id="reg_email" placeholder="Enter Your Email">
                    	<?php echo $errors['reg_email']; ?>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-6" for="reg_pass">Password:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="reg_pass" id="reg_pass" placeholder="Enter Your Password">
                    	<?php echo $errors['reg_pass']; ?>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-6" for="reg_skill">No. of Skills:</label>
                    <div class="col-md-6">
                        <select id="reg_skill">
						    <option value="">select</option>
							<option value="1">One</option>
							<option value="2">Two</option>
							<option value="3">Three</option>
							<option value="4">Four</option>
							<option value="5">Five</option>
                    	</select><?php echo $errors['reg_skill']; ?>
                    </div>
                </div>
                
                <div class="form-group">        
                <div class="col-md-12">
                	<input type="hidden" name="registration_caller" value="self">
                    <input type="submit" class="btn btn-info pull-right" value="Save">
                </div>
                </div>
            </form>
        	<label class="label label-success"><?php echo $success; ?></label>
			<form method=post enctype='multipart/form-data' class="form-horizontal">
			<div class="form-group">
                <label class="control-label col-md-6" for="select_file" id="select_file_o">Select File:</label>
                <div class="col-md-6">
                    <input type="file" id="reg_button_o">
                   	<?php echo $errors['select_file']; ?>
                </div>
            </div>
				<div class="form-group">
                <label class="control-label col-md-6" for="select_file" id="select_file_t">Select File:</label>
                <div class="col-md-6">
                    <input type="file" id="reg_button_t">
                   	<?php echo $errors['select_file']; ?>
                </div>
            </div>
				<div class="form-group">
                <label class="control-label col-md-6" for="select_file" id="select_file_th">Select File:</label>
                <div class="col-md-6">
                    <input type="file" id="reg_button_th">
                   	<?php echo $errors['select_file']; ?>
                </div>
            </div>
				<div class="form-group">
                <label class="control-label col-md-6" for="select_file" id="select_file_f">Select File:</label>
                <div class="col-md-6">
                    <input type="file" id="reg_button_f">
                   	<?php echo $errors['select_file']; ?>
                </div>
            </div>
		    <div class="form-group">
                <label class="control-label col-md-6" for="select_file" id="select_file_fi">Select File:</label>
                <div class="col-md-6">
                    <input type="file" id="reg_button_fi">
                   	<?php echo $errors['select_file']; ?>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-md-12">
                	
                    <input type="submit" class="btn btn-info pull-right" value="upload" id="ub">
                </div>
            </div>
			</form>
			 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
			<script type='text/javascript'>
			    $(document).ready( function() 
				{
	                $("#select_file_o").hide();
                    $("#reg_button_o").hide();
					$("#select_file_t").hide();
                    $("#reg_button_t").hide();
					$("#select_file_th").hide();
                    $("#reg_button_th").hide();
					$("#select_file_f").hide();
                    $("#reg_button_f").hide();
					$("#select_file_fi").hide();
                    $("#reg_button_fi").hide();
					$("#ub").hide();
                });
                $(document).on('change','#reg_skill', function() 
				{
	                var value = $('#reg_skill').val();
                    if(value==1)
					{
                        $("#select_file_o").show();
                        $("#reg_button_o").show();	
						$("#select_file_t").hide();
                        $("#reg_button_t").hide();
						$("#select_file_th").hide();
                        $("#reg_button_th").hide();
						$("#select_file_f").hide();
                        $("#reg_button_f").hide();
						$("#select_file_fi").hide();
                        $("#reg_button_fi").hide();
						$("#ub").show();
                    }
					if(value==2)
					{
						$("#select_file_o").show();
                        $("#reg_button_o").show();
						$("#select_file_t").show();
                        $("#reg_button_t").show();
						$("#select_file_th").hide();
                        $("#reg_button_th").hide();
						$("#select_file_f").hide();
                        $("#reg_button_f").hide();
						$("#select_file_fi").hide();
                        $("#reg_button_fi").hide();
						$("#ub").show();
					}
					if(value==3)
					{
						$("#select_file_o").show();
                        $("#reg_button_o").show();
						$("#select_file_t").show();
                        $("#reg_button_t").show();
						$("#select_file_th").show();
                        $("#reg_button_th").show();
						$("#select_file_f").hide();
                        $("#reg_button_f").hide();
						$("#select_file_fi").hide();
                        $("#reg_button_fi").hide();
						$("#ub").show();
					}
					if(value==4)
					{
						$("#select_file_o").show();
                        $("#reg_button_o").show();
						$("#select_file_t").show();
                        $("#reg_button_t").show();
						$("#select_file_th").show();
                        $("#reg_button_th").show();
						$("#select_file_f").show();
                        $("#reg_button_f").show();
						$("#select_file_fi").hide();
                        $("#reg_button_fi").hide();
						$("#ub").show();
					}
					if(value==5)
					{
						$("#select_file_o").show();
                        $("#reg_button_o").show();
						$("#select_file_t").show();
                        $("#reg_button_t").show();
						$("#select_file_th").show();
                        $("#reg_button_th").show();
						$("#select_file_f").show();
                        $("#reg_button_f").show();
						$("#select_file_fi").show();
                        $("#reg_button_fi").show();
						$("#ub").show();
					}
                });
				
		   </script>
		   
    	</div>		
	</div>
</section>
<?php 
}
?>