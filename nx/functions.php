<?php

/* Dependecies
-------------------------------------------------------- */

//nav walker bootstrap4
require_once('assets/bs4navwalker.php');

// content width
if ( ! isset( $content_width ) ) $content_width = 1400;

/* Setup Theme
-------------------------------------------------------- */

if(! function_exists('nx_setup_theme') ) {

  function nx_setup_theme(){

      // add support titles
      add_theme_support("title-tag");

      // add theme feed links
      add_theme_support( 'automatic-feed-links' );

      // enable featured image
      add_theme_support("post-thumbnails");

      // create custom size images
      add_image_size('nx_big', 1400, 800, true);
      add_image_size('nx_quad', 600, 600, true);
      add_image_size('nx_single', 800, 500, true);

      // create custom menus
      register_nav_menus(array(
        'header' => esc_html__('Header','nx'),
      ));

      //load theme languages
      load_theme_textdomain( 'nx', get_template_directory().'/languages');

  }

}

add_action('after_setup_theme', 'nx_setup_theme');


/* Register Sidebars
-------------------------------------------------------- */

if(! function_exists('nx_sidebars') ) {

  function nx_sidebars(){
    register_sidebar(array(
      'name' => esc_html__('Primary','nx'),
      'id' => 'primary',
      'description' => esc_html__('Main Sidebar','nx'),
      'before_title' => '<h3>' ,
      'after_title' => '</h3>',
      'before_widget' => '<div class="widget my-5 %2$s clearfix">',
      'after_widget' => '</div>',

      )
    );
  }

}

add_action('widgets_init','nx_sidebars');


/* Include javascript files
-------------------------------------------------------- */

if(! function_exists('nx_scripts') ) {

  function nx_scripts(){

    wp_enqueue_script('nx-popper-js', get_template_directory_uri() .'/js/popper.min.js', array('jquery'),null ,true );
    wp_enqueue_script('nx-bootstrap-js', get_template_directory_uri() .'/js/bootstrap.min.js', array('jquery'),null ,true );
    wp_enqueue_script('nx-scripts-js', get_template_directory_uri() .'/js/scripts.js', array('jquery'),null ,true );

    if ( is_singular() ) wp_enqueue_script( "comment-reply" );

  }

}

add_action('wp_enqueue_scripts', 'nx_scripts');


/* Include css files
-------------------------------------------------------- */

if(! function_exists('nx_styles') ) {

  function nx_styles(){

    wp_enqueue_style('nx-bootstrap-css', get_template_directory_uri() .'/css/bootstrap.min.css');
    wp_enqueue_style('nx-style-default-css', get_template_directory_uri() .'/style.css');
    wp_enqueue_style('nx-font-awesome', get_template_directory_uri() .'/css/font-awesome.min.css');
    wp_enqueue_style('nx-font', '//fonts.googleapis.com/css?family=Montserrat:200,300,400,700');


  }

}

add_action('wp_enqueue_scripts', 'nx_styles');


/* Add class to button submit
-------------------------------------------------------- */

function wpdocs_comment_form_defaults( $defaults ) {
  $defaults['class_submit'] = 'btn btn-primary btn-lg';
  return $defaults;
}

add_filter( 'comment_form_defaults', 'wpdocs_comment_form_defaults' );


/* Add class to button submit
-------------------------------------------------------- */

add_action( 'body_class', 'add_class_bg_trasp_body');

function add_class_bg_trasp_body($classes){
  if(has_post_thumbnail() && is_page()){
    array_push($classes,'navbar-transparent');
  } else if(is_front_page()){
    array_push($classes,'navbar-transparent');
  }

  return $classes;

}


/* Add customizer settings
-------------------------------------------------------- */

function nx_customize_register($wp_customize){

  $wp_customize->add_section('nx_logo', array(
      'title' => __('Logo', 'nx'),
      'description' => __('All the info about the logo', 'nx'),
      'priority' => 20
    )
  );


  /* Logo Image */
  $wp_customize ->add_setting('nx_logo_image', array( 'default' => ''));
  $wp_customize ->add_control( new WP_Customize_Image_Control( $wp_customize, 'nx_logo_image', array(
    'section' => 'nx_logo',
    'label' => __('Logo Image', 'nx'),
    'settings' => 'nx_logo_image'
  )));


  /* Logo alt text */
  $wp_customize ->add_setting('nx_logo_alt_text', array( 'default' => 'Logo of the site'));
  $wp_customize ->add_control('nx_logo_alt_text', array(
    'section' => 'nx_logo',
    'label' => __('Logo alt text', 'nx'),
    'type' => 'text'
  ));


}

add_action('customize_register', 'nx_customize_register');





?>
