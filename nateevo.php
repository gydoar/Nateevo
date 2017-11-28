<?php
/*
Plugin Name: Nateevo
Plugin URI: https://github.com/gydoar/Nateevo
Description: Plugin Post type
Version: 1.0
Author: ANDRES DEV
Author URI: https://andres-dev.com
License: GPL2
Text Domain: nateevo
Domain Path: /languages
*/


add_action( 'after_switch_theme', 'nateevo_flush_rewrite_rules' );

function nateevo_flush_rewrite_rules() {
	flush_rewrite_rules();
}

/*--------- Creamos el post type ----------*/

function post_type_nateevo() { 

	if (is_admin()) {
	
		register_post_type( 'products', 
			array( 'labels' => array(
				'name' => __( 'Productos', 'nateevo' ),
				'singular_name' => __( 'Producto', 'nateevo' ),
				'all_items' => __( 'Todos los productos', 'nateevo' ), 
				'add_new' => __( 'Agregar nuevo', 'nateevo' ),
				'add_new_item' => __( 'Agregar nuevo producto', 'nateevo' ), 
				'edit' => __( 'Editar', 'nateevo' ), 
				'edit_item' => __( 'Editar producto', 'nateevo' ), 
				'new_item' => __( 'Nuevo producto', 'nateevo' ), 
				'view_item' => __( 'Ver producto', 'nateevo' ), 
				'search_items' => __( 'Buscar producto', 'nateevo' ), 
				'not_found' =>  __( 'No se encontraron', 'nateevo' ), 
				'not_found_in_trash' => __( 'No se encontraron', 'nateevo' ), 
				'parent_item_colon' => ''
				),
				'description' => __( 'Post type Productos', 'nateevo' ),
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 10, 
				'menu_icon' => 'dashicons-cart', 
				'rewrite'	=> array( 'slug' => 'products', 'with_front' => false ),
				'has_archive' => 'product', 
				'capability_type' => 'post',
				'hierarchical' => false,
				
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes')
			) 
		);

	}
	
}

add_action( 'init', 'post_type_nateevo');



/*--------- Taxonomía Genres ----------*/

function taxonomy_genres(){

		register_taxonomy( 'genres', 
			array('products'), 
			array('hierarchical' => true,    
				'labels' => array(
					'name' => __( 'Géneros', 'nateevo' ), 
					'singular_name' => __( 'Género', 'nateevo' ), 
					'search_items' =>  __( 'Buscar Géneros', 'nateevo' ), 
					'all_items' => __( 'Todos los Géneros', 'nateevo' ), 
					'parent_item' => __( 'Génre padre', 'bonestheme' ), 
					'parent_item_colon' => __( 'Génre padre:', 'bonestheme' ), 
					'edit_item' => __( 'Editar Género', 'nateevo' ), 
					'update_item' => __( 'Actualizar Género', 'nateevo' ), 
					'add_new_item' => __( 'Agregar nuevo Género', 'nateevo' ), 
					'new_item_name' => __( 'Nuevo Género de nombre:', 'nateevo' ) 
				),
				'show_admin_column' => true, 
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'genres' ),
			)
		);
}

add_action( 'init', 'taxonomy_genres');


/*--------- Taxonomía Attributes ----------*/

function taxonomy_attributes(){

		register_taxonomy( 'attributes', 
			array('products'), 
			array('hierarchical' => false,    
				'labels' => array(
					'name' => __( 'Atributos', 'nateevo' ), 
					'singular_name' => __( 'Atributo', 'nateevo' ), 
					'search_items' =>  __( 'Buscar Atributo', 'nateevo' ), 
					'all_items' => __( 'Todos los Atributos', 'nateevo' ), 
					'edit_item' => __( 'Editar Atributo', 'nateevo' ), 
					'update_item' => __( 'Actualizar Atributo', 'nateevo' ), 
					'add_new_item' => __( 'Agregar nuevo Atributo', 'nateevo' ), 
					'new_item_name' => __( 'Nuevo Atributo de nombre:', 'nateevo' ) 
				),
				'show_admin_column' => true, 
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'genres' ),
			)
		);
}

add_action( 'init', 'taxonomy_attributes');



/*--------- Campos Personalizados ----------*/

require_once("meta-box-class/my-meta-box-class.php");

$config = array(
    'id' => 'demo_meta_box',             
    'title' => 'Campos adicionales',      
    'pages' => array('products'),    
    'context' => 'normal',               
    'priority' => 'high',                
    'fields' => array(),                 
    'local_images' => false,             
    'use_with_theme' => false            
);


/*--------- Campos a Internacionalizar ----------*/

$my_meta = new AT_Meta_Box($config);

$my_meta->addDate($prefix.'cf_date',array('name'=> __( 'Select date', 'nateevo' ) ,'format' => 'd/m/yy'));
$my_meta->addImage($prefix.'cf_image',array('name'=> __( 'Select image', 'nateevo' )));
$my_meta->addWysiwyg($prefix.'cf_description',array('name'=> __( 'Rich text', 'nateevo' ),'media_buttons' => false));
 
$my_meta->Finish();


/*--------- Columnas para el admin ----------*/

add_filter('manage_edit-products_columns', 'nateevo_edit_columns');
function nateevo_edit_columns( $columns ) {
    $columns = array(
    	'cb' => '',
        'title' => __( 'Título' ),
        'image' => __( 'Imagen' ),
    );
    return $columns;
}


add_action( 'manage_products_posts_custom_column', 'nateevo_manage_products_columns', 10, 2 );
function nateevo_manage_products_columns( $column, $post_id ) {
	global $post;

	switch($column){
		case 'image':
			$saved_data = get_post_meta($post->ID,'cf_image',true);
			$attachment_id = $saved_data['url'];

			echo '<img width="100px" height="100px" src="'.$attachment_id.'">';
			break;

		default :
			break;
	}
}



add_action('init', 'nateevo_plugin_load_textdomain');

function nateevo_plugin_load_textdomain() {
	
	$text_domain	= 'nateevo';
	$path_languages = basename(dirname(__FILE__)).'/languages/';

 	load_plugin_textdomain($text_domain, false, $path_languages );
}