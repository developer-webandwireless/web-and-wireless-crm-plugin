<?php
/* Manage contact Leads from admin panel of wordpress */
/*
Plugin Name: Contact Form	
Description: A simple CRM system to manage contacts
Author: Rajal Bhave
Version: 1
*/

 
/** Step 2 (from text above). */
add_action( 'admin_menu', 'contacts_plugin_menu' );

/** Step 1. */
function contacts_plugin_menu() {
	//add_options_page( 'My Plugin Options', 'Contacts', 'manage_options', 'contact-form/contact-admin.php', 'my_plugin_options' );
	 $menuHook = add_menu_page('Manage Contacts', 'Contacts', 'manage_options', 'manage-contacts-handle', 
				  'contact_plugin_options',  'dashicons-email-alt', 25);
	//echo $menuHook;
	add_submenu_page(  'manage-contacts-handle', 'Add New Contact', 'Add New Contact',  
					'manage_options', 'add-contact-handle ', 'add_contact_plugin_options' );
	
	add_submenu_page(  'communication-handle', 'Communications', 'Add New communication',  
					'manage_options', 'add-contact-handle ', 'add_contact_plugin_options' );


	//selectively enqueue a javascript file
	function wpdocs_selectively_enqueue_admin_script( $menuHook ) {
		if ( "toplevel_page_manage-contacts-handle" != $menuHook )
		{
			return;
		}
		wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'adminJquery.js', array(), '1.0' );
	}
	add_action( 'admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script' );

				
}


/** Step 3. 
Manage Contacts from Cpanel */

function contact_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	echo '<h1>Manage Contacts</h1>';
	echo '<div class="wrap">';
	echo '<h4>Quickly view, add and update contact details.</h4>';
	echo '<table class="display-contacts">
		<tr>
			<th>Name</th>
			<th>Email</th> 
			<th>Phone </th>
			<th>Type </th>
			<th>Date Added </th>
			<th colspan="3">Action </th>
		</tr>
		';


		global $wpdb;
		$table_name = $wpdb->prefix . 'contact_form';
		$rows = $wpdb->get_results( "SELECT * FROM {$table_name}"  );
		$i = 0;
			foreach ($rows as $row) {
				echo '<tr><td>'.  $row->name . ' </td>'; 
				echo '<td>'.  $row->email . ' </td>'; 
				echo '<td>'.  $row->phone . ' </td>'; 
				echo '<td>'.  $row->type . '</td>';
				$newDate = date("d - M - Y", strtotime($row->date_added));
				echo '<td>'. $newDate . '</td>';
				echo '<td><a data-record-name="'.$row->name.'" 
							 data-record-email="'.$row->email.'"
							 data-record-phone="'.$row->phone.'"
							 
				class="viewContact dashicons dashicons-visibility" href="#"></a></td>';
				
				echo '<td><a data-record-id="'.$row->id.'"
				class="dashicons dashicons-edit" href="#"></a></td>';
				
				echo '<td><a data-record-id="'.$row->id.'" 
					         data-record-name="'.$row->name.'" 
				class="deleteContact dashicons dashicons-trash" href="#"></a></td></tr>';
				$i++;

			}
	echo '</table> <br /><br />
		 <a style="float: right;" href="#"> Download contacts to a CSV file  <i class="dashicons dashicons-arrow-down-alt"></i></a>
	</div>';
	
	echo '			<div id ="contactDetails" title="Contact Details" >
					<table>
						  <tr>
							<td><strong>Name</strong></td>
							<td id = "dialog-name"></td>
						 </tr>
						  <tr>
							<td><strong>Email</strong></td>
							<td id = "dialog-email"></td>
						</tr>
						<tr>
							<td><strong>Phone</strong></td>
							<td id = "dialog-phone"></td>
						</tr>

					</table>
					<br />
					<a href="#">Download vCard <i class="dashicons dashicons-welcome-widgets-menus"></i></a><br />
					
					</div>
					
					<div id ="contactDelete" title="Delete Contact"></div>
					';
					

}


function add_contact_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<h1>Add New Contact</h1>';
	echo '<div style="margin: 0 150px 0 40px; float: left;">';
	
	
	echo '<form  id="add_contact" name="add_contact" method="post" action="">  
  <fieldset>  
  <div class="wrap_label_text">
    <label for="cname" id="cname">Name<span class="required">*</span></label>
    <input type="text" name="cname" id="cname" value="" required/>
  </div>
  <div class="wrap_label_text">
    <label for="email" id="email">Email</label>
    <input type="text" name="email" id="email" size="30" value="" required/>
  </div>
  <div class="wrap_label_text">
    <label for="phone" id="phone">Phone</label>
    <input type="text" name="phone" id="phone" size="30" value="" />
  </div>
  <div class="wrap_label_text">
    <label for="address" id="address">Address<span class="required"></span></label>
    <textarea name="address" rows="4" id="address" ></textarea>
  </div>
  <div class="wrap_label_text">
    <label for="type" id="type">Type</label>
    <input type="text" name="type" id="type" size="30" value="" />
  </div>
  <div class="wrap_label_text">
    <label for="comments" id="comment">Comments<span class="required"></span></label>
    <textarea name="comments" id="comments" ></textarea>
  </div>


  <input type="hidden" name="action" value="sendForm"/>
    <div><input id="submit" type="submit" name="submit" value="Add Contact" />  </div>
  </fieldset>  
</form>


</div>';

//Form for contact custom field
	
 echo '<div style="margin: 0 0 0 40px; float: left;">
<form  id="custom_field" name="custom_field" >  	
<h3>Add custom field</h3>
  <div class="wrap_label_text">
	<SELECT name="element">
		<OPTION value="text">Text</OPTION>
		<OPTION value="text_block">Text Block</OPTION>
		<OPTION value="date">Date</OPTION>
	</SELECT>

	<INPUT style="margin-left: 20px;" type="button" value="Add" onclick="add(document.forms[0].element.value)"/>
</div>

</FORM>
 </div>

';

}

?>

