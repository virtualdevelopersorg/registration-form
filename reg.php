<?php
/**
 * Plugin Name: Register
 * Description: To create registration-form	
 * Version: 1.0.0
 * Author: Prakash Ranjan Kumar
 * Author URI: http://www.kumarpc.herobo.com
 * */
 
  function add_roles_on_plugin_activation() {
       add_role( 'custom_role', 'Custom Subscriber', array( 'read' => true, 'level_0' => true ) );
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
$role=get_role( $administrator  );
echo $role;
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
	}
	   //On success
       if ( ! is_wp_error( $user_id ) ) 
       {
           echo "User created : ". $user_id;
       }
	   
	   
	/* get role by id 
	
         $user = wp_get_current_user();
         echo $user->roles[0];   
	*/
	
/*  list all role available in database and insert new role, display error when already exist the role

     global $wp_roles;
     $roles = $wp_roles->get_names();

     // Below code will print the all list of roles.
     //print_r($roles);
	 foreach($roles as $role) {
		 echo $role;
	 }
	 $result = add_role('hello2',__( 'hello1' ),
     array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => true,
        'delete_posts' => false, // Use false to explicitly deny
           )
        );
     if ( null !== $result ) 
	 {
	    echo 'Yay! New role created!';
     }
     else 
	 {
          echo 'Oh... the basic_contributor role already exists.';
     }
*/    
	
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