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
				
				'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes')
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

