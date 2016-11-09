<?php
/** Load the Core Files */
require_once( trailingslashit( get_template_directory() ) . 'lib/init.php' );
new Contango();

/** Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'contango_theme_setup' );

/** Theme setup function. */
function contango_theme_setup() {

	/** Add theme support for Feed Links. */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/** Post Formats */
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'video' ) );

	/** Add theme support for Custom Background. */
	add_theme_support( 'custom-background', array( 'default-color' => 'e9e9e9', 'default-image' => '%s/images/bg-pattern.png', 'wp-head-callback' => 'contango_custom_background_callback' ) );

	/** Set content width. */
	contango_set_content_width( 580 );

	/** Add custom image sizes. */
	add_action( 'init', 'contango_add_image_sizes' );

	function afolio_script(){
		//wp_enqueue_style('main', get_stylesheet_directory_uri() );
		wp_register_script( 'justscript', get_template_directory_uri() . '/justscript.js' );
		wp_enqueue_script('justscript');

		wp_register_style('teststyle', get_template_directory_uri() . '/teststyle.css');
		wp_enqueue_style('teststyle');
	}

	add_action('wp_enqueue_scripts', 'afolio_script');

}

/** Adds custom image sizes */
function contango_add_image_sizes() {
	add_image_size( 'featured', 200, 180, true );
}

function add_comment_fields($fields) {
    $fields['age'] = '<p class="kod">+380</p><p class="comment-form-age"><label for="age">' . __( 'Телефон' ) . '</label>' .
        '<input id="age" name="age" type="text" size="30" /></p>';
    return $fields;
}
add_filter('comment_form_default_fields','add_comment_fields');

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What
 * happens is the theme's background image hides the user-selected background color.  If a user selects a
 * background image, we'll just use the WordPress custom background callback.
 *
 * @link http://core.trac.wordpress.org/ticket/16919
 */
function contango_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) ) {
		return;
	}

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php
}

