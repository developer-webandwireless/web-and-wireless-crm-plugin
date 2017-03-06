<?php 
/* @package contact-form */
/* Adds a contact form to the website 
Checks for validations using jQuery
Makes an Ajax call to send email and insert data into the database*/
/*
Plugin Name: Contact Form	
Description: Displays a contact us form
Author: Rajal Bhave
Version: 0.1
*/

require_once('adminMenu.php');

class contactForm extends WP_Widget{
	
	
	public function __construct(){
		$params = array(
		'name' => 'Contact Form',
		'description' => 'Displays a contact us form'
		);
		parent::__construct('ContactForm', '', $params);
		
	}
	
public function widget($args, $instance){
	 extract($args);
	//var_dump($args);
	extract($instance);
	
	$title = apply_filters('widget_title', $title );
	$description = apply_filters('widget_description', $description);
	
	  echo $before_widget;
            echo $before_title . $title . $after_title; 
			//contactForm();
			
	  echo $after_widget;
 
 }
 
  //Backend form for widget
 public function form($instance){
	extract($instance);
	//widget configuration
	?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"> Title : </label>
		<input id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value ="<?php echo !empty($title) ?  $title : ''; ?>"
		/>
<?php
 
}
}


//Create admin interface
function contactForm(){
	$form_html = '
<div id="success">
  <div id="success-show">
    <p>Your request has been successfully submitted.
We will get back to you shortly.</p>
  </div>
</div>

<div id="error">
  <div id="error-show">
    <p>Something went wrong, try refreshing and submitting the form again.</p>
  </div>
</div>

	
	<form id="contact" name="contact" method="post" action="../wp-content/plugins/contact-form/sendMail.php">  
  <fieldset>  
  <div class="wrap_label_text">
    <label for="cname" id="cname">Name<span class="required">*</span></label>
    <input type="text" name="cname" id="cname" value="" required/>
  </div>
  <div class="wrap_label_text">
    <label for="email" id="email">Email<span class="required">*</span></label>
    <input type="text" name="email" id="email" size="30" value="" required/>
  </div>
  <div class="wrap_label_text">
    <label for="phone" id="phone">Phone</label>
    <input type="text" name="phone" id="phone" size="30" value="" />
  </div>
  <div class="wrap_label_text">
    <label for="Message" id="message">Message<span class="required">*</span></label>
    <textarea name="message" id="message" required></textarea>
  </div>
  <input type="hidden" name="action" value="sendForm"/>
    <div><input id="submit" type="submit" name="submit" value="Send" />  </div>
  </fieldset>  
</form>

';

return $form_html;
	
}

function deliver_mail() {

    // if the submit button is clicked, send the email
    if ( isset( $_POST['submit'] ) ) { echo 'send email'; }
}

//create shortcode
add_shortcode('contact_form','contactForm');



if(!is_admin()){
		  wp_enqueue_script('google-hosted-jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
		  //register jQuery file

		function register_script(){
			wp_register_script('form_script', plugins_url('/form.js', __FILE__));
			wp_enqueue_script('form_script');

		}

		add_action('init','register_script');


}

if(is_admin()){
	function add_libraries() {
				wp_register_script('javascript-jquery-ui', '//code.jquery.com/ui/1.11.4/jquery-ui.js"', false);
				wp_register_style('style-jquery-ui', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"', false);

				wp_enqueue_script('javascript-jquery-ui');
				wp_enqueue_style('style-jquery-ui');

	}
	add_action( 'init', 'add_libraries' );

}

		  //register css file

		function register_css(){
			wp_register_style('form_style', plugins_url('/form.css', __FILE__));
			wp_enqueue_style('form_style');

		}

		add_action('init','register_css');




//including jQuery libraries
function add_jQuery_libraries() {
 
    // Registering Scripts

     wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('google-hosted-jquery'));
     
	 wp_register_script('javascript-ajax-submit', 'http://malsup.github.com/jquery.form.js"', false);

    // Enqueueing Scripts to the head section
    
    wp_enqueue_script('jquery-validation-plugin');
	wp_enqueue_script('javascript-ajax-submit');

}
 
// Wordpress action that says, hey wait! lets add the scripts mentioned in the function as well.
add_action( 'init', 'add_jQuery_libraries' );


//register widget with WordPress
add_action('widgets_init', 'register_contactForm');
function register_contactForm(){
	register_widget('contactForm');
}
		//wp_enqueue_script( 'fws-contactform-script', plugin_dir_url(__FILE__).'form.js', array('jquery') );
		wp_localize_script( 'form_script', 'ajax_object_acf',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'plugin_base_path' => plugin_dir_url(__FILE__)
			)
		);
		
		

?>