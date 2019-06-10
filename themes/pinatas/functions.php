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


/* Pedidos */
add_action( 'add_meta_boxes', 'pedidos_custom_metabox' );
function pedidos_custom_metabox(){
    add_meta_box( 'pedidos_meta', 'Información pedido', 'display_pedidos_atributos', 'pedidos', 'advanced', 'default');
}

function display_pedidos_atributos( $pedidos ){
    $piezas   = esc_html( get_post_meta( $pedidos->ID, 'pedidos_piezas', true ) );
    $cliente  = esc_html( get_post_meta( $pedidos->ID, 'pedidos_cliente', true ) );
    $entrega  = esc_html( get_post_meta( $pedidos->ID, 'pedidos_entrega', true ) );
    $estatus  = esc_html( get_post_meta( $pedidos->ID, 'pedidos_estatus', true ) );
?>
    <table class="pb-custom-fields">
        <tr>
            <th>
                <label for="pedidos_piezas">Piezas:</label>
                <input type="number" id="pedidos_piezas" name="pedidos_piezas" value="<?php echo $piezas; ?>">
            </th>
            <th>
                <label for="pedidos_cliente">Cliente:</label>
                <input type="text" id="pedidos_cliente" name="pedidos_cliente" value="<?php echo $cliente; ?>">
            </th>
            <th colspan="2">
                <label for="pedidos_entrega">Fecha de entrega:</label>
                <input type="date" id="pedidos_entrega" name="pedidos_entrega" value="<?php echo $entrega; ?>">
            </th>
        </tr>
        <tr>
            <th>
                <label for="pedidos_estatus">Estatus:</label>
                <select name="pedidos_estatus" id="pedidos_estatus" required>
                    <option value="Abierto" <?php selected($estatus, 'Abierto'); ?>>Abierto</option>
                    <option value="Cerrado" <?php selected($estatus, 'Cerrado'); ?>>Cerrado</option>
                </select><br>               
            </th>
        </tr>
    </table>
<?php }

add_action( 'save_post', 'pedidos_save_metas', 10, 2 );
function pedidos_save_metas( $idpedidos, $pedidos ){
    if ( $pedidos->post_type == 'pedidos' ){
        if ( isset( $_POST['pedidos_piezas'] ) ){
            update_post_meta( $idpedidos, 'pedidos_piezas', $_POST['pedidos_piezas'] );
        }
        if ( isset( $_POST['pedidos_cliente'] ) ){
            update_post_meta( $idpedidos, 'pedidos_cliente', $_POST['pedidos_cliente'] );
        }
        if ( isset( $_POST['pedidos_entrega'] ) ){
            update_post_meta( $idpedidos, 'pedidos_entrega', $_POST['pedidos_entrega'] );
        }
        if ( isset( $_POST['pedidos_estatus'] ) ){
            update_post_meta( $idpedidos, 'pedidos_estatus', $_POST['pedidos_estatus'] );
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

/* Nuevo pedido */
add_action ('template_redirect', 'redirect_pedido');
function redirect_pedido() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitPedido'] ) ) {
        wp_redirect('stock-pinatas/#pedido_creado');
    }
}

/* Editar pedido */
add_action ('template_redirect', 'redirect_editpedido');
function redirect_editpedido() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditPedido'] ) ) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        wp_redirect($actual_link . '#pedido_actualizado');
    }
}

/* Cerrar pedido */
add_action ('template_redirect', 'redirect_closepedido');
function redirect_closepedido() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitClosePedido'] ) ) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        wp_redirect($actual_link . '#pedido_cerrado');
    }
}


/*
** Columnas admin
*/

/* Cliente */
add_filter( 'manage_clientes_posts_columns', 'set_custom_edit_clientes_columns' );
function set_custom_edit_clientes_columns($columns) {
    $columns['clientes_nivel']   = __( 'Nivel', 'pbolita' );
    $columns['clientes_correo']  = __( 'Correo', 'pbolita' );
    $columns['clientes_cel']     = __( 'Celular', 'pbolita' );
    $columns['clientes_tel']     = __( 'Teléfono', 'pbolita' );
    $columns['clientes_direccion'] = __( 'Dirección', 'pbolita' );

    return $columns;
}

add_action( 'manage_clientes_posts_custom_column' , 'custom_clientes_column', 10, 2 );
function custom_clientes_column( $column, $post_id ) {
    switch ( $column ) {
        case 'clientes_nivel' :
            $nivel  = get_post_meta( $post_id, 'clientes_nivel', true );
            if( $nivel != "")
                echo $nivel;
            else
                echo "-";
            break;
        case 'clientes_correo' :
            $correo  = get_post_meta( $post_id, 'clientes_correo', true );
            if( $correo != "")
                echo $correo;
            else
                echo "-";
            break;
        case 'clientes_cel' :
            $cel  = get_post_meta( $post_id, 'clientes_cel', true );
            if( $cel != "")
                echo $cel;
            else
                echo "-";
            break;
        case 'clientes_tel' :
            $tel  = get_post_meta( $post_id, 'clientes_tel', true );
            if( $tel != "")
                echo $tel;
            else
                echo "-";
            break;
        case 'clientes_direccion' :
            $direccion  = get_post_meta( $post_id, 'clientes_direccion', true );
            if( $direccion != "")
                echo $direccion;
            else
                echo "-";
            break;
    }
}

/* Pedido */
add_filter( 'manage_pedidos_posts_columns', 'set_custom_edit_pedidos_columns' );
function set_custom_edit_pedidos_columns($columns) {
    $columns['pedidos_piezas']  = __( 'Piezas', 'pbolita' );
    $columns['pedidos_cliente'] = __( 'Cliente', 'pbolita' );
    $columns['pedidos_entrega'] = __( 'Fecha de entrega', 'pbolita' );
    $columns['pedidos_estatus'] = __( 'Estatus', 'pbolita' );

    return $columns;
}

add_action( 'manage_pedidos_posts_custom_column' , 'custom_pedidos_column', 10, 2 );
function custom_pedidos_column( $column, $post_id ) {
    switch ( $column ) {
        case 'pedidos_piezas' :
            $piezas  = get_post_meta( $post_id, 'pedidos_piezas', true );
            if( $piezas != "")
                echo $piezas;
            else
                echo "-";
            break;
        case 'pedidos_cliente' :
            $cliente  = get_post_meta( $post_id, 'pedidos_cliente', true );
            if( $cliente != "")
                echo $cliente;
            else
                echo "-";
            break;
        case 'pedidos_entrega' :
            $entrega  = get_post_meta( $post_id, 'pedidos_entrega', true );
            /* Fecha en español */
            setlocale(LC_ALL,"es_ES");
            $entrega = strftime("%d/%B/%Y", strtotime($entrega));            
            if( $entrega != "")

                echo $entrega;
            else
                echo "-";
            break;
        case 'pedidos_estatus' :
            $estatus  = get_post_meta( $post_id, 'pedidos_estatus', true );
            if( $estatus != "")
                echo $estatus;
            else
                echo "-";
            break;
    }
}