<?php
/**
* Plugin Name: Rebrander - White Label WP
* Plugin URI: https://www.dmadhav.com.np/
* Description: Rebrand your WordPress website with white label information.
* Version: 1.1
* Author: Madhav Dhungana
* Author URI: https://dmadhav.com.np/
**/




function rebrander_custom_title( $login_title ) {
    return str_replace(array( ' &lsaquo;', ' &#8212; WordPress'), array( ' &bull;', ),get_option('blogname') );
    }
    add_filter( 'login_title', 'rebrander_custom_title' );
// Removes WordPress from title


function rebrander_site_login_logo() {
$custom_logo_id = get_theme_mod( 'custom_logo' );
$rebrander_logo_data = wp_get_attachment_image_src( $custom_logo_id , array( 100, 50 ) );
$rebrander_logo_url = $rebrander_logo_data[0];
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo esc_url($rebrander_logo_url); ?>);
		
        }
    </style>
<?php
}
add_action( 'login_enqueue_scripts', 'rebrander_site_login_logo' );



function rebrander_my_login_logo_url() {
return home_url();
}
add_filter( 'login_headerurl', 'rebrander_my_login_logo_url' );

// removes the logo link 

function  rebrander_custom_login_title() {
    return get_option('blogname');
}
add_filter('login_headertitle', 'rebrander_custom_login_title');

// add blog title as login logo title


function rebrander_dashboard_footer_version() {
    remove_filter( 'update_footer', 'core_update_footer' ); 
}

add_action( 'admin_menu', 'rebrander_dashboard_footer_version' );
//Removes Dashboard Footer

add_filter( 'admin_footer_text', '__return_false' );

function rebrander_remove_screen_options(){
    return false;
}
add_filter('screen_options_show_screen', 'rebrander_remove_screen_options');
// Removes Screen options tab 


function rebrander_remove_dashboard_help_tabs($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}
add_filter( 'rebrander_contextual_help', 'rebrander_remove_dashboard_help_tabs', 999, 3 );
//Removes help tab

add_filter('admin_title', 'rebrander_my_admin_title', 10, 2);

function rebrander_my_admin_title($admin_title, $title)
{
        return get_bloginfo('name').' &bull; '.$title;
}
// removes dashboard title: WordPress


add_action( 'wp_before_admin_bar_render', 'rebrander_before_admin_bar_fixer', 999 ); 
function rebrander_before_admin_bar_fixer()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');				// Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');				// Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');				// Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');		// Remove the WordPress documentation
    $wp_admin_bar->remove_menu('support-forums');		// Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');				// Remove the feedback link	
    $wp_admin_bar->remove_menu('updates');				// Remove the updates link
    $wp_admin_bar->remove_menu('comments');				// Remove the comments link
    $wp_admin_bar->remove_menu('new-content');			// Remove the content link
    $wp_admin_bar->remove_menu('customize');			// Remove customizer link
    $wp_admin_bar->remove_menu('updraft_admin_node');	// Remove Updraft plugin link
    $wp_admin_bar->remove_menu('w3tc');					// Remove W3 total cache plugin link
}

add_filter( 'allow_dev_auto_core_updates', '__return_true' );
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );


// hide update notifications
function rebrander_remove_updates_cora(){
    global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
    }
    add_filter('pre_site_transient_update_core','rebrander_remove_updates_cora'); //hide updates for WordPress itself
    add_filter('pre_site_transient_update_plugins','rebrander_remove_updates_cora'); //hide updates for all plugins
    add_filter('pre_site_transient_update_themes','rebrander_remove_updates_cora'); //hide updates

    remove_action('welcome_panel', 'wp_welcome_panel');


    function rebrander_remove_dashboard_mta() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'woocommerce_dashboard_recent_reviews', 'dashboard', 'normal' );
        remove_meta_box( 'dlm_popular_downloads', 'dashboard', 'normal' );
    }
    add_action( 'admin_init', 'rebrander_remove_dashboard_mta' );

    
    function rebrander_remove_dashboard_version_message(){
    return false;
    }
    add_action('update_right_now_text' , 'rebrander_remove_dashboard_version_message');



    function rebrander_new_mail_from($old) {
        return get_option('admin_email');  // From Email Address
    }
    add_filter('wp_mail_from', 'rebrander_new_mail_from');
    
    function rebrander_new_mail_from_name($old) {
        return get_bloginfo('name'); // From Email Name
    }
    add_filter('wp_mail_from_name', 'rebrander_new_mail_from_name');

    add_action( 'admin_init', 'rebrander_remove_submenu_rebrander' );
function rebrander_remove_submenu_rebrander() {
    remove_submenu_page( 'index.php', 'update-core.php' );
}