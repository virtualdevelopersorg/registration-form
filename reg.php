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
	if(isset($_POST['submit_image']))
{
 $uploadfile=$_FILES["upload_file"]["tmp_name"];
 $folder="images/";
 move_uploaded_file($_FILES["upload_file"]["tmp_name"], "$folder".$_FILES["upload_file"]["name"]);
 exit();
}
?>
<style><link rel="stylesheet" type="text/css" href="/js/jquery.tokenize.css" /></style>
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
                        <select id="reg_skill" class="multiselect" multiple="multiple">
							<?php echo $d; ?>
                    	</select><?php echo $errors['reg_skill']; ?>
                    </div>
                </div>               
                <div class="form-group">        
                <div class="col-md-12">
                	<input type="hidden" name="registration_caller" value="self">
                    <input type="submit" class="btn btn-info pull-right" value="Sign Up">
                </div>
                </div>
            </form>
			
          	<label class="label label-success"><?php echo $success; ?></label>	
            <form class="update_post" method = "POST" enctype = "multipart/form-data">
				<div class="form-group">                 
                    <div id="result"></div>
                </div>
			</form>			
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
                result += "<input type='file' name='file_name" + (parseInt(i) + 1) + "' value='" + value.trim() + "'>";
				
                result += "<input type='button' class='btn btn-info pull-right' id='upfile" + (parseInt(i) + 1) + "' value='Upload'"+"'>";
               
                result += "</div>";
                
            });
        }
        //Set Result
        $("#result").html(result);

       
});
$(document).on('click','#upfile', function()  { 
alert('hello');
});
</script>
<?php
}
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.tokenize.js"></script>