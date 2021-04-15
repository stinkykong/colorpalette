<?php
/**
 * TCGInfinity Pro.
 *
 * This file adds functions to the TCGInfinity Pro Theme.
 *
 * @package TCGInfinity
 * @author  The Crouch Group
 * @license GPL-2.0+
 * @link    http://thecrouchgroup.com/themes/tcginfinity/
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Include customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Add image upload and color select to theme customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'tcginfinity', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'tcginfinity' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'TCGInfinity Pro' );
define( 'CHILD_THEME_URL', 'http://thecrouchgroup.com/themes/tcginfinity/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'tcginfinity_enqueue_scripts_styles' );
function tcginfinity_enqueue_scripts_styles() {

	wp_enqueue_style( 'tcginfinity-fonts', '//fonts.googleapis.com/css?family=Bodoni+Moda&display=swap:400,500,700|Red+Hat+Display&display=swap:300,400,500,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'tcginfinity-ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'tcginfinity-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'tcginfinity-match-height', get_stylesheet_directory_uri() . '/js/match-height.js', array( 'jquery' ), '0.5.2', true );
	wp_enqueue_script( 'tcginfinity-responsive-menu2', get_stylesheet_directory_uri() . '/js/responsive-menu2.js', array( 'jquery' ), '1.0.0', true );

	wp_enqueue_script( 'tcginfinity-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'tcginfinity' ),
		'subMenu'  => __( 'Menu', 'tcginfinity' ),
	);
	wp_localize_script( 'tcginfinity-responsive-menu', 'TCGInfinityL10n', $output );

}

//* Enqueue custom WooCommerce styles when WooCommerce active
add_filter( 'woocommerce_enqueue_styles', 'tcginfinity_woocommerce_styles' );
function tcginfinity_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['tcginfinity-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen'
	);

	return $enqueue_styles;

}

//* Add support for Genesis Connect for Woocommerce
add_theme_support( 'genesis-connect-woocommerce' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 300,
	'height'          => 100,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add image sizes
add_image_size( 'mini-thumbnail', 75, 75, TRUE );
add_image_size( 'team-member', 600, 600, TRUE );
add_image_size( 'featured-image', 300, 300, TRUE );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Remove header right widget area
//*unregister_sidebar( 'header-right' );  STEVE COMMENTS THIS OUT

//* Remove secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove output of primary navigation right extras
//* remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
//* remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
//* add_action( 'genesis_theme_settings_metaboxes', 'tcginfinity_remove_genesis_metaboxes' );
//* function tcginfinity_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
//* 
//* 	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
//* 
//* }

//* Rename primary and secondary navigation menus
//* add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'tcginfinity' ), 'secondary' => __( 'Footer Menu', 'tcginfinity' ) ) );

//* Reposition primary navigation menu at bottom of header
 remove_action( 'genesis_after_header', 'genesis_do_nav' );
 add_action( 'genesis_header', 'genesis_do_nav', 14 );

//* Reposition the secondary navigation menu into content area
 remove_action( 'genesis_after_header', 'genesis_do_subnav' );
 add_action( 'genesis_before_entry_content', 'genesis_do_subnav', 5 );

//* Add offscreen content if active
add_action( 'genesis_before_header', 'tcginfinity_offscreen_content_output' );
function tcginfinity_offscreen_content_output() {

	$button = '<button class="offscreen-content-toggle"><i class="icon ion-ios-close-empty"></i> <span class="screen-reader-text">' . __( 'Hide Offscreen Content', 'tcginfinity' ) . '</span></button>';

	if ( is_active_sidebar( 'offscreen-content' ) ) {

		echo '<div class="offscreen-content-icon"><button class="offscreen-content-toggle"><i class="icon ion-ios-more"></i> <span class="screen-reader-text">' . __( 'Show Offscreen Content', 'tcginfinity' ) . '</span></button></div>';

	}
	
	genesis_widget_area( 'offscreen-content', array(
		'before' => '<div class="offscreen-content"><div class="offscreen-container"><div class="widget-area">' . $button . '<div class="wrap">',
		'after'  => '</div></div></div></div>'
	));

}

//* Reduce secondary navigation menu to one level depth
//* add_filter( 'wp_nav_menu_args', 'tcginfinity_secondary_menu_args' );
//* function tcginfinity_secondary_menu_args( $args ) {
//* 
//* 	if ( 'secondary' != $args['theme_location'] ) {
//* 		return $args;
//* 	}
//* 
//* 	$args['depth'] = 1;
//* 	return $args;
//* 
//* }

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'tcginfinity_author_box_gravatar' );
function tcginfinity_author_box_gravatar( $size ) {

	return 100;

}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'tcginfinity_comments_gravatar' );
function tcginfinity_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

//* Setup widget counts
function tcginfinity_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

function tcginfinity_widget_area_class( $id ) {

	$count = tcginfinity_count_widgets( $id );

	$class = '';

	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {	
		$class .= ' widget-halves';
	}

	return $class;

}

//* steve adds to work with Gutenberg - resource: Studio Press 
add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );

/**

* Adds Gutenberg opt-in features and styling.

*

* @since 2.7.0

*/

function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.

require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';

}
//* end steve adds to work with Gutenberg


//* Steve adds this function to add categories to body class on single posts
function websen_body_class_add_categories( $classes ) {
 
	// Only proceed if we're on a single post page
	if ( !is_single() )
		return $classes;
 
	// Get the categories that are assigned to this post
	$post_categories = get_the_category();
 
	// Loop over each category in the $categories array
	foreach( $post_categories as $current_category ) {
 
		// Add the current category's slug to the $body_classes array
		$classes[] = 'category-' . $current_category->slug;
 
	}
 
	// Finally, return the $body_classes array
	return $classes;
}
add_filter( 'body_class', 'websen_body_class_add_categories' );


//* **!!!** MEMBERSHIP LISTING SECTION OF functions.php *********************************

//* activate ACF Image-Crop plugin in admin
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
    include_once('acf-image-crop/acf-image-crop.php');
}



//* set sort order of member-listings
function my_pre_get_posts( $query ) {
	
	// do not modify queries in the admin
	if( is_admin() ) {
		
		return $query;
		
	}
	

	// only modify queries for 'member-listing' post type
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'member-listing' ) {
		
		$query->set('orderby', 'last_name');	
		$query->set('meta_key', 'last_name');	 
		$query->set('order', 'desc'); 
		
	}
	

	// return
	return $query;

}

add_action('pre_get_posts', 'my_pre_get_posts');

//* end set sort order of memlistings

//* add ACF Options page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

//* end add ACF Options page

//* Force Gravity forms form id ?? to place form fields into memlisting post type

add_filter( 'gform_post_data', 'change_post_type', 10, 3 );      
function change_post_type( $post_data, $form, $entry ) {
    //only change post type on form id 5
    if ( $form['id'] != 1 ) {
       return $post_data;
    }

    $post_data['post_type'] = 'member-listing';
    return $post_data;
}

add_image_size( 'member-listing', 300, 300, TRUE );

//* **!!!** END MEMBERSHIP LISTING SECTION OF functions.php *********************************


//* steve's attempts to order the professions 
add_action( 'genesis_before_loop', 'ntg_do_query' );
/** Changes the Query before the Loop */
function ntg_do_query() {
 
    if( is_tax( array( 'profession', 'post-type-archive-cpcalprofessional', 'tax-profession', 'attorneys', 'financial-professionals', 'mental-health-professionals', 'professional' ) ) ){
        global $query_string;
 
        query_posts( wp_parse_args( $query_string, array( 'meta_key' => 'last_name', 'orderby' => 'rand', 'order' => 'ASC' ) ) );
    }

}


//* Steve adds from 2021 theme for background colors
if ( ! function_exists( 'twenty_twenty_one_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Twenty Twenty-One 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_setup() {
		// Custom background color.
		add_theme_support(
			'custom-background',
			array(
					'default-color' => 'd1e4dd',
		)
	);

		// Editor color palette.
		$black     = '#000000';
		$greypurple = '#7B5EA9';
		$purple    = '#944DFF';
		$dkpurple = '#6633B3';
		$deeppurple = '#421F77';
		$deepgreen = '#114035';
		$dkchalkgreen = '#4A6A62';
		$medgreen = '#769F8B';
		$chalkgreen  = '#87A69F';
		$greenwhite = '#DFE3DD';
		$offwhite  = '#EDEDED';
		$white     = '#FFFFFF';

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Black', 'tcginfinity' ),
					'slug'  => 'black',
					'color' => $black,
				),
				array(
					'name'  => esc_html__( 'Grey Purple', 'tcginfinity' ),
					'slug'  => 'greypurple',
					'color' => $greypurple,
				),
				array(
					'name'  => esc_html__( 'Purple', 'tcginfinity' ),
					'slug'  => 'purple',
					'color' => $purple,
				),
				array(
					'name'  => esc_html__( 'Dark Purple', 'tcginfinity' ),
					'slug'  => 'dkpurple',
					'color' => $dkpurple,
				),
				array(
					'name'  => esc_html__( 'Deep Purple', 'tcginfinity' ),
					'slug'  => 'deeppurple',
					'color' => $deeppurple,
				),
				array(
					'name'  => esc_html__( 'Deep Green', 'tcginfinity' ),
					'slug'  => 'deepgreen',
					'color' => $deepgreen,
				),
				array(
					'name'  => esc_html__( 'Dark Chalk Green', 'tcginfinity' ),
					'slug'  => 'dkchalkgreen',
					'color' => $dkchalkgreen,
				),
				array(
					'name'  => esc_html__( 'Chalk Green', 'tcginfinity' ),
					'slug'  => 'chalkgreen',
					'color' => $chalkgreen,
				),
				array(
					'name'  => esc_html__( 'Whitish Green', 'tcginfinity' ),
					'slug'  => 'greenwhite',
					'color' => $greenwhite,
				),
				array(
					'name'  => esc_html__( 'Off White', 'tcginfinity' ),
					'slug'  => 'offwhite',
					'color' => $offwhite,
				),
				array(
					'name'  => esc_html__( 'White', 'tcginfinity' ),
					'slug'  => 'white',
					'color' => $white,
				),
			)
			
		);
	

		add_theme_support(
			'editor-gradient-presets',
			array(
				array(
					'name'     => esc_html__( 'Chalkie Purple', 'tcginfinity' ),
					'gradient' => 'linear-gradient(160deg, ' . $greypurple . ' 0%, ' . $offwhite . ' 100%)',
					'slug'     => 'chalkie-purple',
				),
				array(
					'name'     => esc_html__( 'Dark Chalkie Purple', 'tcginfinity' ),
					'gradient' => 'linear-gradient(160deg, ' . $dkpurple . ' 0%, ' . $greypurple . ' 100%)',
					'slug'     => 'dark-chalkie-purple',
				),
				array(
					'name'     => esc_html__( 'Chalkie Green', 'tcginfinity' ),
					'gradient' => 'linear-gradient(160deg, ' . $chalkgreen . ' 0%, ' . $greenwhite . ' 100%)',
					'slug'     => 'chalkie-green',
				),
				array(
					'name'     => esc_html__( 'Dark Chalkie Green', 'tcginfinity' ),
					'gradient' => 'linear-gradient(160deg, ' . $dkchalkgreen . ' 0%, ' . $chalkgreen . ' 100%)',
					'slug'     => 'dark-chalkie-green',
				),
				array(
					'name'     => esc_html__( 'Vibrant Green', 'tcginfinity' ),
					'gradient' => 'linear-gradient(160deg, ' . $deepgreen . ' 0%, ' . $medgreen . ' 100%)',
					'slug'     => 'vibrant-green',
				),
				array(
					'name'     => esc_html__( 'Dark Vibrant Green', 'tcginfinity' ),
					'gradient' => 'linear-gradient(160deg, ' . $deepgreen . ' 0%, ' . $dkchalkgreen . ' 100%)',
					'slug'     => 'dark-vibrant-green',
				),
			)
		);
	}
}

add_action( 'after_setup_theme', 'twenty_twenty_one_setup' );
//* end steve adds from 2021 theme for background colors




//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'tcginfinity' ),
	'description' => __( 'This is the front page 1 section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'tcginfinity' ),
	'description' => __( 'This is the front page 2 section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'tcginfinity' ),
	'description' => __( 'This is the front page 3 section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'tcginfinity' ),
	'description' => __( 'This is the front page 4 section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'tcginfinity' ),
	'description' => __( 'This is the front page 5 section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-6',
	'name'        => __( 'Front Page 6', 'tcginfinity' ),
	'description' => __( 'This is the front page 6 section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-7',
	'name'        => __( 'Front Page 7', 'tcginfinity' ),
	'description' => __( 'This is the front page 7 section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'lead-capture',
	'name'        => __( 'Lead Capture', 'tcginfinity' ),
	'description' => __( 'This is the lead capture section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'offscreen-content',
	'name'        => __( 'Offscreen Content', 'tcginfinity' ),
	'description' => __( 'This is the offscreen content section.', 'tcginfinity' ),
) );
genesis_register_sidebar( array(
	'id'          => 'holding-tank',
	'name'        => __( 'Holding Tank', 'tcginfinity' ),
	'description' => __( 'Non Functioning Storage of Unused Widgets.', 'tcginfinity' ),
) );
