<?php
/**
 * Plugin Name: Register
 * Description: To transfer from one imap server to another imap server
 * Version: 1.0.0
 * Author: Prakash Ranjan Kumar
 * Author URI: http://www.kumarpc.herobo.com
 * */
function create_registration_table()
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'register'; //Defining a table name.
	$sql = "CREATE TABLE $table_name(
										id int(11) NOT NULL AUTO_INCREMENT,
                                        name varchar(200) NOT NULL,
                                        mobile_no varchar(200) NOT NULL,
										email varchar(200) NOT NULL,
										password varchar(200) NOT NULL,                        						
                                        date_time varchar(200) NOT NULL,
										PRIMARY KEY id (id)
									)$charset_collate;"; //Defining query to create table.
									
	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    	//Creating a table in cureent wordpress
		dbDelta($sql);

}
register_activation_hook( __FILE__, 'create_registration_table' );

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
		  global $wpdb;
		  $wpdb->insert( 
						   $wpdb->prefix . 'register', 
		                   array( 
					                'name' => $name, 
					                'mobile_no' => $mobile_no,
               		                'email' => $email,
					                'password' => $pass,
					                'date_time' => current_time('mysql', 1)
			    	            )
						);
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