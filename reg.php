<?php
/**
 * Plugin Name: Email Transfer
 * Description: To transfer from one imap server to another imap server
 * Version: 1.0.0
 * Author: Tarun Kumar
 * Author URI: http://www.tarun.pro/
 * */
function create_email_transfer_table()
{
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'email_transfer'; //Defining a table name.
	$sql = "CREATE TABLE $table_name(
										id int(11) NOT NULL AUTO_INCREMENT,
                                        name varchar(200) NOT NULL,
                                        mobile_no varchar(200) NOT NULL,
										payment_type varchar(200) NOT NULL,
										payment_status varchar(200) NOT NULL,
                                        email_transfer_status varchar(200) NOT NULL,						
                                        date_time varchar(200) NOT NULL,
										PRIMARY KEY id (id)
									)$charset_collate;"; //Defining query to create table.
									
	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    	//Creating a table in cureent wordpress
		dbDelta($sql);

}
register_activation_hook( __FILE__, 'create_email_transfer_table' );

//createing menu
add_action("admin_menu","create_menus");
	
	function create_menus() 
	{
			add_object_page(
							 'Register',
							 'Registration',
							 'install_plugins',
							 'email-transfer',
							 'email_transfer'
						    );
    
    	    
	}
	//createing menu
	
	//This function is used to create email setting page
	
add_shortcode('Register', 'register_shortcode');
function register_shortcode()
{	
	$email_transfer_setting_caller = $_POST['email_transfer_setting_caller'];

	if($email_transfer_setting_caller == "self")
    {
    	$api_key = strip_tags(addslashes(trim($_POST['api_key'])));
    	$secret_key = strip_tags(addslashes(trim($_POST['secret_key'])));
    	$token = strip_tags(addslashes(trim($_POST['token'])));
		
		$errors = array();
    	
    	if(empty($api_key)) $errors['api_key'] = "Empty";
    	if(empty($secret_key)) $errors['secret_key'] = "Empty";
        if(empty($token)) $errors['token'] = "Empty";
		if(empty($errors))
		{
		  global $wpdb;
		  $c=array( 
					'api_key' => $api_key, 
					'secret_key' => $secret_key,
               		'token' => $token
			    	);
         update_option('Instamojo', $c);
		}
	}	
//This function is used to create email setting page  	
?>
	<section class="container">
	<div class="row">
    	<div class="col-md-6">
        	 <form class="form-horizontal" method="post">
             	 <div class="form-group">
                    <label class="control-label col-md-6" for="api_key">API Key:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="api_key" id="api_key" placeholder="Enter Instamojo API Key">
                    	<?php echo $errors['api_key']; ?>
                    </div>
                </div>
             
             	 <div class="form-group">
                    <label class="control-label col-md-6" for="secret_key">Secret Key:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="secret_key" id="secret_key" placeholder="Enter Instamojo Secret Key">
                    	<?php echo $errors['secret_key']; ?>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-6" for="token">Token:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="token" id="token" placeholder="Enter Instamojo Token">
                    	<?php echo $errors['token']; ?>
                    </div>
                </div>
				
                <div class="form-group">        
                <div class="col-md-12">
                	<input type="hidden" name="email_transfer_setting_caller" value="self">
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