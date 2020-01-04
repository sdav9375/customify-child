<?php

    
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
  wp_enqueue_style( 'customify-parent-style', get_template_directory_uri().'/style.css' );
  wp_dequeue_style( 'customify-style' );
  wp_enqueue_style( 'customify-child-style', get_stylesheet_directory_uri().'/style.css' );
}

define( 'MPP_GALLERY_SLUG', 'projects');

/**
 * Filter wall gallery title
 *
 * @param string $title name of the wall gallery.
 * @param array  $args {
 *  Context details.
 * @type string $component component name(e.g groups|members|sitewide)
 * @type int    $component_id numeric component id( e.g group id or user id based on the component)
 * @type string $type media type(e.g photo, video,audio, doc etc)
 *
 * }
 *
 * @return string new title
 */
function mpp_custom_wall_gallery_name( $title, $args ) {
    // Profile photo gallery etc.
    // Profile video gallery etc.
    return sprintf( 'Profile %s projects', strtolower( mpp_get_type_singular_name( $args['type'] ) ) );
}
add_filter( 'mpp_wall_gallery_title', 'mpp_custom_wall_gallery_name', 10, 2 );

function mpp_enqueue_datepicker() {
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui' );  
}
add_action( 'wp_enqueue_scripts', 'mpp_enqueue_datepicker' );
	
// Don't allow subscribers access to wp-admin backend
function restrict_access_admin_panel(){
    global $current_user;
    get_currentuserinfo();
    if ($current_user->user_level <  2 && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php') {
        wp_redirect( get_bloginfo('url') );
        exit;
    }
}
add_action('admin_init', 'restrict_access_admin_panel', 1);


function bp_ant_hide_tabs() {
	global $bp;
	if( class_exists( 'buddypress' )  ) :
  
	if ( bp_is_user() && !is_super_admin() && !bp_is_my_profile() ) {


	bp_core_remove_nav_item( 'profile' );
	bp_core_remove_nav_item( 'activity' );
	} 
	if ( bp_is_user() && !is_super_admin() && bp_is_my_profile() ) {
			bp_core_remove_subnav_item( 'profile', 'view' );
		
	}
	endif;
}
add_action( 'bp_setup_nav', 'bp_ant_hide_tabs', 15 );

function bp_ant_rename_profile_tabs() {
  
      buddypress()->members->nav->edit_nav( array( 'name' => __( 'Projects', 'textdomain' ) ), 'projects' );
  
}
add_action( 'bp_actions', 'bp_ant_rename_profile_tabs' );

// Disable public messaging
add_filter('bp_get_send_public_message_button', '__return_false');

/**
 * Filter display name to show BP custom field display name
 * 
 */

add_filter( 'bp_core_get_user_displayname', 'ant_get_display_name', 10, 2 );
add_filter( 'bp_get_member_name', 'ant_get_display_name', 10, 2 );

function ant_get_display_name ( $display_name, $user_id ) {
	
	return	$lastname= bp_get_profile_field_data('field=Display Name&user_id='.$user_id);	
}

add_filter( 'get_the_date', 'ant_modify_get_the_date', 10, 3 ); 
function ant_modify_get_the_date (  $value, $the_date, $post ) {
	if ( $post->post_type == 'anttopic' ) {
		return date( 'F Y', strtotime( $value ) );
	} else {
		return $value;
	}
	
}

