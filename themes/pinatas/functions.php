<?php 

/**
* Define paths to javascript, styles, theme and site.
**/
define( 'JSPATH', get_stylesheet_directory_uri() . '/js/' );
define( 'THEMEPATH', get_stylesheet_directory_uri() . '/' );
define( 'SITEURL', get_site_url() . '/' );


/*------------------------------------*\
	#SNIPPETS
\*------------------------------------*/
require_once( 'inc/post-types.php' );
require_once( 'inc/pages.php' );
/*require_once( 'inc/taxonomies.php' );*/

/*------------------------------------*\
	#GENERAL FUNCTIONS
\*------------------------------------*/

/**
* Enqueue frontend scripts and styles
**/
add_action( 'wp_enqueue_scripts', function(){
 
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.2.1.min.js', array(''), '2.1.1', true );
	wp_enqueue_script( 'cycle_js', JSPATH.'jquery.cicle2.min.js', array(), '', true );
	wp_enqueue_script( 'pb_functions', JSPATH.'functions.js', array(), '1.0', true );
 
	wp_localize_script( 'pb_functions', 'siteUrl', SITEURL );
	wp_localize_script( 'pb_functions', 'theme_path', THEMEPATH );
	
	// $is_home = is_front_page() ? "1" : "0";
	// wp_localize_script( 'pb_functions', 'isHome', $is_home );
 
});

/**
* Configuraciones WP
*/

// Agregar css y js al administrador
function load_custom_files_wp_admin() {
        wp_register_style( 'pb_wp_admin_css', THEMEPATH . '/admin/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'pb_wp_admin_css' );

        wp_register_script( 'pb_wp_admin_js', THEMEPATH . 'admin/admin-script.js', false, '1.0.0' );
        wp_enqueue_script( 'pb_wp_admin_js' );        
}
add_action( 'admin_enqueue_scripts', 'load_custom_files_wp_admin' );

//Habilitar thumbnail en post
add_theme_support( 'post-thumbnails' ); 

//Habilitar menú (aparece en personalizar)
add_action('after_setup_theme', 'add_top_menu');
function add_top_menu(){
	register_nav_menu('top_menu',__('Top menu'));
}

//Delimitar número palabras excerpt
/*function custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );*/


/**
* Optimización
*/

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


/**
* SEO y Analitics
**/

//Código Analitics
// function add_google_analytics() {
//     echo '<script src="https://www.google-analytics.com/ga.js" type="text/javascript"></script>';
//     echo '<script type="text/javascript">';
//     echo 'var pageTracker = _gat._getTracker("UA-117075138-1");';
//     echo 'pageTracker._trackPageview();';
//     echo '</script>';
// }
// add_action('wp_footer', 'add_google_analytics');

/* Aplaza el análisis de JavaScript para una carga más rápida */
if(!is_admin()) {
    // Move all JS from header to footer
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
}

/**
* SUPPORT WOOCOMMERCE
*/
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

//Hook orden
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 30 );


/**
* CUSTOM FUNCTIONS
*/

/* Clientes */
add_action( 'add_meta_boxes', 'clientes_custom_metabox' );
function clientes_custom_metabox(){
    add_meta_box( 'clientes_meta', 'Información cliente', 'display_clientes_atributos', 'clientes', 'advanced', 'default');
}

function display_clientes_atributos( $clientes ){
    $nivel   	= esc_html( get_post_meta( $clientes->ID, 'clientes_nivel', true ) );
    $correo   	= esc_html( get_post_meta( $clientes->ID, 'clientes_correo', true ) );
    $cel   		= esc_html( get_post_meta( $clientes->ID, 'clientes_cel', true ) );
    $tel   		= esc_html( get_post_meta( $clientes->ID, 'clientes_tel', true ) );
    $direccion  = esc_html( get_post_meta( $clientes->ID, 'clientes_direccion', true ) );
?>
    <table class="pb-custom-fields">
        <tr>
            <th>
                <label for="clientes_nivel">Nivel*:</label>
                <select name="clientes_nivel" id="clientes_nivel" required>
                    <option value="Normal" <?php selected($nivel, 'Normal'); ?>>Normal</option>
                    <option value="Plata" <?php selected($nivel, 'Plata'); ?>>Plata</option>
                    <option value="Oro" <?php selected($nivel, 'Oro'); ?>>Oro</option>
                </select><br>
            </th>
            <th>
                <label for="clientes_correo">Correo:</label>
                <input type="email" id="clientes_correo" name="clientes_correo" value="<?php echo $correo; ?>">
            </th>
        </tr>
        <tr>
            <th>
                <label for="clientes_cel">Celular:</label>
                <input type="tel" id="clientes_cel" name="clientes_cel" value="<?php echo $cel; ?>">
            </th>
            <th>
                <label for="clientes_tel">Teléfono:</label>
                <input type="tel" id="clientes_tel" name="clientes_tel" value="<?php echo $tel; ?>">
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <label for="clientes_direccion">Dirección:</label>
                <input type="text" id="clientes_direccion" name="clientes_direccion" value="<?php echo $direccion; ?>">
            </th>
        </tr>
    </table>
<?php }

add_action( 'save_post', 'clientes_save_metas', 10, 2 );
function clientes_save_metas( $idclientes, $clientes ){
    if ( $clientes->post_type == 'clientes' ){
        if ( isset( $_POST['clientes_nivel'] ) ){
            update_post_meta( $idclientes, 'clientes_nivel', $_POST['clientes_nivel'] );
        }
        if ( isset( $_POST['clientes_correo'] ) ){
            update_post_meta( $idclientes, 'clientes_correo', $_POST['clientes_correo'] );
        }
        if ( isset( $_POST['clientes_cel'] ) ){
            update_post_meta( $idclientes, 'clientes_cel', $_POST['clientes_cel'] );
        }
        if ( isset( $_POST['clientes_tel'] ) ){
            update_post_meta( $idclientes, 'clientes_tel', $_POST['clientes_tel'] );
        }
        if ( isset( $_POST['clientes_direccion'] ) ){
            update_post_meta( $idclientes, 'clientes_direccion', $_POST['clientes_direccion'] );
        }
    }
}


/**
* Redirecciones
*/

/* Nuevo cliente */
add_action ('template_redirect', 'redirect_cliente');
function redirect_cliente() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitCliente'] ) ) {
        wp_redirect('stock-pinatas/#cliente_creado');
    }
}