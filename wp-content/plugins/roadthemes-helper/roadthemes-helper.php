<?php
/**
 * Plugin Name: RoadThemes Helper
 * Plugin URI: http://roadthemes.com/
 * Description: The helper plugin for RoadThemes themes.
 * Version: 1.0.0
 * Author: RoadThemes
 * Author URI: http://roadthemes.com/
 * Text Domain: flaton
 * License: GPL/GNU.
 /*  Copyright 2015  RoadThemes  (email : roadthemez@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( file_exists( ABSPATH . 'wp-admin/includes/file.php' ) ) {
	require_once(ABSPATH . 'wp-admin/includes/file.php');
}
require_once('slider-setting.php');
require_once('road-products.php');

//Add less compiler
function compileLessFile($input, $output, $params) {
   require_once( plugin_dir_path( __FILE__ ).'less/lessc.inc.php' );
   
	$less = new lessc;
	$less->setVariables($params);
	//$less->setFormatter("compressed");
	
    // input and output location
    $inputFile = get_template_directory().'/less/'.$input;
    $outputFile = get_template_directory().'/css/'.$output;

    try {
		$less->compileFile($inputFile, $outputFile);
	} catch (Exception $ex) {
		echo "lessphp fatal error: ".$ex->getMessage();
	}
}
function compileChildLessFile($input, $output, $params) {
	require_once( plugin_dir_path( __FILE__ ).'less/lessc.inc.php' );
	$less = new lessc;
	$less->setVariables($params);
	
    // input and output location
    $inputFile = get_stylesheet_directory().'/less/'.$input;
    $outputFile = get_stylesheet_directory().'/css/'.$output;

    try {
		$less->compileFile($inputFile, $outputFile);
	} catch (Exception $ex) {
		echo "lessphp fatal error: ".$ex->getMessage();
	}
}
//Shortcodes 
add_shortcode( 'roadlogo', 'monsta_logo_shortcode' );
add_shortcode( 'roadmainmenu', 'monsta_mainmenu_shortcode' ); 
add_shortcode( 'roadmainmenumobile', 'monsta_mainmenumobile_shortcode' );
add_shortcode( 'roadcategoriesmenu', 'monsta_roadcategoriesmenu_shortcode' );
add_shortcode( 'roadlangswitch', 'monsta_roadlangswitch_shortcode' );
add_shortcode( 'roadsocialicons', 'monsta_roadsocialicons_shortcode' );
add_shortcode( 'roadminicart', 'monsta_roadminicart_shortcode' );
add_shortcode( 'roadproductssearch', 'monsta_roadproductssearch_shortcode' );
add_shortcode( 'roadproductssearchmobile', 'monsta_roadproductssearchmobile_shortcode' );
add_shortcode( 'roadmainmenumobile', 'monsta_mainmenumobile_shortcode' );
add_shortcode( 'roadcopyright', 'monsta_roadcopyright_shortcode' );
add_shortcode( 'ourbrands', 'monsta_brands_shortcode' );
add_shortcode( 'monsta_counter', 'monsta_counter_shortcode' );
add_shortcode( 'list_categories', 'monsta_list_categories_shortcode' );
add_shortcode( 'categoriescarousel', 'monsta_categoriescarousel_shortcode' );
add_shortcode( 'latestposts', 'monsta_latestposts_shortcode' );
add_shortcode( 'monsta_map', 'monsta_contact_map' );
add_shortcode( 'roadtimesale', 'monsta_roadtimesale_shortcode' ); 
add_shortcode( 'magnifier_map', 'monsta_magnifier_options' );
function monsta_blog_sharing() {
    global $post;

    $monsta_opt = get_option( 'monsta_opt' );
    
    $share_url = get_permalink( $post->ID );
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
    $postimg = $large_image_url[0];
    $posttitle = get_the_title( $post->ID );
    ?>
    <div class="widget widget_socialsharing_widget"> 
        <ul class="social-icons">
            <li><a class="facebook social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>'); return false;" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter social-icon" href="#" title="Twitter" onclick="javascript: window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>'); return false;" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a class="pinterest social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>'); return false;" title="Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a></li>
            <li><a class="gplus social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>'); return false;" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            <li><a class="linkedin social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.$share_url.'&amp;title='.$posttitle; ?>'); return false;" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
        </ul>
    </div>
    <?php
}
function monsta_product_sharing() {
    $monsta_opt = get_option( 'monsta_opt' );
    
    if(isset($_POST['data'])) { // for the quickview
        $postid = intval( $_POST['data'] );
    } else {
        $postid = get_the_ID();
    }
    
    $share_url = get_permalink( $postid );

    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
    $postimg = $large_image_url[0];
    $posttitle = get_the_title( $postid );
    ?>
    <div class="widget widget_socialsharing_widget"> 
        <ul class="social-icons">
            <li><a class="facebook social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>'); return false;" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter social-icon" href="#" title="Twitter" onclick="javascript: window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>'); return false;" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a class="pinterest social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>'); return false;" title="Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a></li>
            <li><a class="gplus social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>'); return false;" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            <li><a class="linkedin social-icon" href="#" onclick="javascript: window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.$share_url.'&amp;title='.$posttitle; ?>'); return false;" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
        </ul>
    </div>
    <?php
} 

add_action( 'add_meta_boxes', 'monsta_add_meta_box');
add_action( 'save_post', 'monsta_save_meta_box_data');
function monsta_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'monsta_meta_box', 'monsta_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta( $post->ID, '_monsta_post_intro', true );

    echo '<label for="monsta_post_intro">';
    esc_html_e( 'This content will be used to replace the featured image, use shortcode here', 'monsta' );
    echo '</label><br />';
    wp_editor( $value, 'monsta_post_intro', $settings = array() );
}
function monsta_custom_sidebar_callback( $post ) {
    global $wp_registered_sidebars;

    $monsta_opt = get_option( 'monsta_opt' );

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'monsta_meta_box', 'monsta_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */

    //show sidebar dropdown select
    $csidebar = get_post_meta( $post->ID, '_monsta_custom_sidebar', true );

    echo '<label for="monsta_custom_sidebar">';
    esc_html_e( 'Select a custom sidebar for this post/page', 'monsta' );
    echo '</label><br />';

    echo '<select id="monsta_custom_sidebar" name="monsta_custom_sidebar">';
        echo '<option value="">'.esc_html__('- None -', 'monsta').'</option>';
        foreach($wp_registered_sidebars as $sidebar){
            $sidebar_id = $sidebar['id'];
            if($csidebar == $sidebar_id){
                echo '<option value="'.$sidebar_id.'" selected="selected">'.$sidebar['name'].'</option>';
            } else {
                echo '<option value="'.$sidebar_id.'">'.$sidebar['name'].'</option>';
            }
        }
    echo '</select><br />';

    //show custom sidebar position
    $csidebarpos = get_post_meta( $post->ID, '_monsta_custom_sidebar_pos', true );

    echo '<label for="monsta_custom_sidebar_pos">';
    esc_html_e( 'Sidebar position', 'monsta' );
    echo '</label><br />';

    echo '<select id="monsta_custom_sidebar_pos" name="monsta_custom_sidebar_pos">'; ?>
        <option value="left" <?php if($csidebarpos == 'left') {echo 'selected="selected"';}?>><?php echo esc_html__('Left', 'monsta'); ?></option>
        <option value="right" <?php if($csidebarpos == 'right') {echo 'selected="selected"';}?>><?php echo esc_html__('Right', 'monsta'); ?></option>
    <?php echo '</select>';
}

function monsta_add_meta_box() {

    $screens = array( 'post', 'page' );

    foreach ( $screens as $screen ) {
        if($screen == 'post'){
            add_meta_box(
                'monsta_post_intro_section',
                esc_html__( 'Post featured content', 'monsta' ),
                'monsta_meta_box_callback',
                $screen
            );
            add_meta_box(
                'monsta_custom_sidebar',
                esc_html__( 'Custom Sidebar', 'monsta' ),
                'monsta_custom_sidebar_callback',
                $screen
            );
        }
        if($screen == 'page'){
            add_meta_box(
                'monsta_custom_sidebar',
                esc_html__( 'Custom Sidebar', 'monsta' ),
                'monsta_custom_sidebar_callback',
                $screen
            );
        }
    }
}
function monsta_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['monsta_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['monsta_meta_box_nonce'], 'monsta_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Make sure that it is set.
    if ( ! ( isset( $_POST['monsta_post_intro'] ) || isset( $_POST['monsta_custom_sidebar'] ) ) )  {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['monsta_post_intro'] );
    // Update the meta field in the database.
    update_post_meta( $post_id, '_monsta_post_intro', $my_data );

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['monsta_custom_sidebar'] );
    // Update the meta field in the database.
    update_post_meta( $post_id, '_monsta_custom_sidebar', $my_data );

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['monsta_custom_sidebar_pos'] );
    // Update the meta field in the database.
    update_post_meta( $post_id, '_monsta_custom_sidebar_pos', $my_data );
    
}
?>