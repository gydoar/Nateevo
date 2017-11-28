<?php
/*
Plugin Name: nateevo
Plugin URI: https://github.com/gydoar/Nateevo
Description: Plugin Post type
Version: 1.0
Author: ANDRES DEV
Author URI: https://andres-dev.com
License: GPL2
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
				'name' => __( 'Productos', 'andres-dev.com' ),
				'singular_name' => __( 'Producto', 'andres-dev.com' ),
				'all_items' => __( 'Todos los productos', 'andres-dev.com' ), 
				'add_new' => __( 'Agregar nuevo', 'andres-dev.com' ),
				'add_new_item' => __( 'Agregar nuevo producto', 'andres-dev.com' ), 
				'edit' => __( 'Editar', 'andres-dev.com' ), 
				'edit_item' => __( 'Editar producto', 'andres-dev.com' ), 
				'new_item' => __( 'Nuevo producto', 'andres-dev.com' ), 
				'view_item' => __( 'Ver producto', 'andres-dev.com' ), 
				'search_items' => __( 'Buscar producto', 'andres-dev.com' ), 
				'not_found' =>  __( 'No se encontraron', 'andres-dev.com' ), 
				'not_found_in_trash' => __( 'No se encontraron', 'andres-dev.com' ), 
				'parent_item_colon' => ''
				),
				'description' => __( 'Post type Productos', 'andres-dev.com' ),
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
					'name' => __( 'Géneros', 'andres-dev.com' ), 
					'singular_name' => __( 'Género', 'andres-dev.com' ), 
					'search_items' =>  __( 'Buscar Géneros', 'andres-dev.com' ), 
					'all_items' => __( 'Todos los Géneros', 'andres-dev.com' ), 
					'parent_item' => __( 'Génre padre', 'bonestheme' ), 
					'parent_item_colon' => __( 'Génre padre:', 'bonestheme' ), 
					'edit_item' => __( 'Editar Género', 'andres-dev.com' ), 
					'update_item' => __( 'Actualizar Género', 'andres-dev.com' ), 
					'add_new_item' => __( 'Agregar nuevo Género', 'andres-dev.com' ), 
					'new_item_name' => __( 'Nuevo Género de nombre:', 'andres-dev.com' ) 
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
					'name' => __( 'Atributos', 'andres-dev.com' ), 
					'singular_name' => __( 'Atributo', 'andres-dev.com' ), 
					'search_items' =>  __( 'Buscar Atributo', 'andres-dev.com' ), 
					'all_items' => __( 'Todos los Atributos', 'andres-dev.com' ), 
					'edit_item' => __( 'Editar Atributo', 'andres-dev.com' ), 
					'update_item' => __( 'Actualizar Atributo', 'andres-dev.com' ), 
					'add_new_item' => __( 'Agregar nuevo Atributo', 'andres-dev.com' ), 
					'new_item_name' => __( 'Nuevo Atributo de nombre:', 'andres-dev.com' ) 
				),
				'show_admin_column' => true, 
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'genres' ),
			)
		);
}

add_action( 'init', 'taxonomy_attributes');


/*--------- Custom Fields ----------*/

require_once("meta-box-class/my-meta-box-class.php");

/*
* configure your meta box
*/
$config = array(
    'id' => 'demo_meta_box',             // meta box id, unique per meta box 
    'title' => 'Campos adicionales',      // meta box title
    'pages' => array('products'),    // post types, accept custom post types as well, default is array('post'); optional
    'context' => 'normal',               // where the meta box appear: normal (default), advanced, side; optional
    'priority' => 'high',                // order of meta box: high (default), low; optional
    'fields' => array(),                 // list of meta fields (can be added by field arrays) or using the class's functions
    'local_images' => false,             // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false            //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);


/*
* Initiate your meta box
*/
$my_meta = new AT_Meta_Box($config);
//date field
$my_meta->addDate($prefix.'cf_date',array('name'=> 'Seleccionar fecha ','format' => 'd/m/yy'));
//Image field
$my_meta->addImage($prefix.'cf_image',array('name'=> 'Seleccionar imagen '));
//wysiwyg field
$my_meta->addWysiwyg($prefix.'cf_description',array('name'=> 'Texto enriquecido ','media_buttons' => false));
 
/*
* Don't Forget to Close up the meta box deceleration
*/
//Finish Meta Box Deceleration
$my_meta->Finish();















/*-------------------------------------------------------------------------------
	Custom Columns
-------------------------------------------------------------------------------*/

/**
 * Función que añade columnas al listado de casos. En el "add_filter"
 * se cambia el post type donde afecta el filtro de la siguiente manera:
 * manage_edit-{{post_type}}_columns.
 */
add_filter('manage_edit-products_columns', 'nx_edit_columns');
function nx_edit_columns( $columns ) {
    $columns = array(
    	'cb' => '',
        'title' => __( 'Título' ),
        'image' => __( 'Imagen' ),
    );
    return $columns;
}

/**
 * Función para mostrar contenido dentro de las columnas.
 */
add_action( 'manage_products_posts_custom_column', 'my_manage_products_columns', 10, 2 );
function my_manage_products_columns( $column, $post_id ) {
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