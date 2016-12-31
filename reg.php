<?php
/**
 * Plugin Name: Register
 * Description: To transfer from one imap server to another imap server
 * Version: 1.0.0
 * Author: Prakash Ranjan Kumar
 * Author URI: http://www.kumarpc.herobo.com
 * */


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
							add_submenu_page(
                             'register',
                             'Register',
                             'Register',
                             'install_plugins',
                             'register',
                             'register'
                            );
    
    	    
	}
	//creating menu
	
	//This function is used to create registration-form	
	
add_shortcode('Register', 'registration_shortcode');
function registration_shortcode()
{	
	$registration_caller = $_POST['registration_caller'];

	if($registration_caller == "self")
    {
    	$name = strip_tags(addslashes(trim($_POST['name'])));
    	$mobile_no = strip_tags(addslashes(trim($_POST['mobile_no'])));
    	$email = strip_tags(addslashes(trim($_POST['email'])));
		$pass = strip_tags(addslashes(trim($_POST['pass'])));
		
		$errors = array();
    	
    	if(empty($name)) $errors['name'] = "Empty";
    	if(empty($mobile_no)) $errors['mobile_no'] = "Empty";
        if(empty($email)) $errors['email'] = "Empty";
		if(empty($pass)) $errors['pass'] = "Empty";
		if(empty($errors))
		{
		   $userdata = array(
                               'name' => $name,
                               'mobile_no' => $mobile_no,
	                           'email' => $email,
                               'password' => $pass,
	                           'date_time' => current_time('mysql', 1)	
                            );
                            $user_id = wp_insert_user( $userdata ) ;
		}
       //On success
       if ( ! is_wp_error( $user_id ) ) 
       {
           echo "User created : ". $user_id;
       }
	}
	
//This function is used to create registration-form	
?>
	<section class="container">
	<div class="row">
    	<div class="col-md-6">
        	 <form class="form-horizontal" method="post">
             	 <div class="form-group">
                    <label class="control-label col-md-6" for="name">Name:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name">
                    	<?php echo $errors['name']; ?>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-6" for="mobile_no">Mobile Number:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter Your Mobile Number">
                    	<?php echo $errors['mobile_no']; ?>
                    </div>
                </div>
             
             	 <div class="form-group">
                    <label class="control-label col-md-6" for="email">Email:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter Your Email">
                    	<?php echo $errors['pass']; ?>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-6" for="pass">Password:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="pass" id="pass" placeholder="Enter Your Password">
                    	<?php echo $errors['pass']; ?>
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
    	</div>		
	</div>
</section>
<?php 
}
?>