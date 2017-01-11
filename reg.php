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
add_action("admin_menu","vd_registration_create_menu");
	
	function vd_registration_create_menu() 
	{
			add_object_page(
							 'Register',
							 'Register',
							 'install_plugins',
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
                       $success="Sign up sucess";
 		}      	
          $user_id = wp_insert_user( $userdata ) ;	
		if($_FILES["zip_file"]["name"]) 
		{
    	    $filename = $_FILES["zip_file"]["name"];
    	    $source = $_FILES["zip_file"]["tmp_name"];
    	    $type = $_FILES["zip_file"]["type"];
     
    	    $name = explode(".", $filename);
         	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    	    foreach($accepted_types as $mime_type) 
			{
    		    if($mime_type == $type) 
				{
    			    $okay = true;
    			    break;
    		    } 
    	    } 
     
    	    $continue = strtolower($name[1]) == 'zip' ? true : false;
    	    if(!$continue) 
			{
    		    $message = "The file you are trying to upload is not a .zip file. Please try again.";
    	    }
     
            /* PHP current path */
            $path = dirname(__FILE__).'/';  // absolute path to the directory where zipper.php is in
            $filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
            $filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
      
            $targetdir = $path . $filenoext; // target directory
            $targetzip = $path . $filename; // target zip file
     
            /* create directory if not exists', otherwise overwrite */
            /* target directory is same as filename without extension */
     
            if (is_dir($targetdir))  rmdir_recursive ( $targetdir);
     
            mkdir($targetdir, 0777);
     
            /* here it is really happening */
     
    	    if(move_uploaded_file($source, $targetzip)) 
			{
    		    $zip = new ZipArchive();
    		    $x = $zip->open($targetzip);  // open the zip file to extract
    		    if ($x === true) 
				{
    			    $zip->extractTo($targetdir); // place in the directory with same name  
    			    $zip->close();
    			    unlink($targetzip);
         		}
    		    $message = "Your .zip file was uploaded and unpacked.";
    	    } 
			else
				{	
    		        $message = "There was a problem with the upload. Please try again.";
    	        }
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

       $tax = 'skill';
       // get the terms of taxonomy
       $terms = get_terms( $tax, $args = array('hide_empty' => false,));// do not hide empty terms
       // loop through all terms
       foreach( $terms as $term )
       {
		   $id.=$term->term_id;
		   //$t_name.=$term->name;
		   //echo '<li>'. $t_name.'</li>';
		   $d.="<option value=".$id.">".$term->name."</option>";
        }

        if($user_id)
       {
	      $args1 = array(
                         'role' => 'administrator',
                         'orderby' => 'user_nicename',
                         'order' => 'ASC'
                        );
                $sub = get_users($args1);
          foreach ($sub as $user) 
          {
	          $um=$user->display_name;
	          $ue=$user->user_email;
              wp_mail( $ue, "Hello",$um);
          }
       }
?>  
<style><link rel="stylesheet" type="text/css" href="/js/jquery.tokenize.css" /></style>
<section class="container">
	<div class="row">
    	<div class="col-md-6">
        	<form class="form-horizontal" method="post" action="<?php get_permalink();?>" enctype="multipart/form-data">
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
                        <select id="reg_skill" class="multiselect" multiple="multiple">
							<?php echo $d; ?>
                    	</select><?php echo $errors['reg_skill']; ?>
                    </div>
                </div>   
                 <label>Choose a zip file to upload: <input type="file" name="zip_file" /></label>				
                <div class="form-group">        
                <div class="col-md-12">
                	<input type="hidden" name="registration_caller" value="self">
                    <input type="submit" class="btn btn-info pull-right" value="Sign Up">
                </div>
                </div>
            </form>
			
			
          	<label class="label label-success"><?php echo $success; ?></label>	
            <form enctype="multipart/form-data" method="post" action="">
				<div class="form-group">                 
                    <div id="result"></div>
                </div>
			</form>			
			<?php if($message) echo "<p>$message</p>"; ?>
    	</div>
	</div>
</section>
<script>
$(document).on('change','#reg_skill', function() 
{
	var multipleValues = $("#reg_skill").val() || "";
        var result = "";
        if (multipleValues != "") {
            var aVal = multipleValues.toString().split(",");
            var count = $("#reg_skill :selected").length;
            $.each(aVal, function(i, value) {
				result +="<label class='control-label col-md-6'>Select File:</label>";
                result += "<div class='col-md-6'>";
                result += "<input type='file' name='zip_file'>";              
                result += "</div>";             
            });
        }
        //Set Result
        $("#result").html(result);

       
});
</script>
<?php
}
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.tokenize.js"></script>