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


/* Remover PRIVATE de título en post privado */
function remove_private_prefix($title) {
    $title = str_replace('Privado: ', '', $title);
    return $title;
}
add_filter('the_title', 'remove_private_prefix');

/**
* Send mail by SMTP
*/
add_action( 'phpmailer_init', 'send_smtp_email' );
function send_smtp_email( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = SMTP_HOST;
    $phpmailer->SMTPAuth   = SMTP_AUTH;
    $phpmailer->Port       = SMTP_PORT;
    $phpmailer->SMTPSecure = SMTP_SECURE;
    $phpmailer->Username   = SMTP_USERNAME;
    $phpmailer->Password   = SMTP_PASSWORD;
    $phpmailer->From       = SMTP_FROM;
    $phpmailer->FromName   = SMTP_FROMNAME;

    $phpmailer->SMTPKeepAlive = true;
}

/* $message wp_mail in html (not text/plain) */
function transforme_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','transforme_content_type' );


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
* Perfiles - Permisos
*/
//Hide item admin menu for certain user profile
function pb_remove_menu_items() {
    remove_menu_page('edit.php'); // Posts
    remove_menu_page('edit-comments.php'); // Comments
    //Editor (Esther y Verónica)
    if( current_user_can( 'shop_manager' ) ):
        
        remove_menu_page('edit.php?post_type=page'); // Pages 
        remove_menu_page('upload.php'); 
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('themes.php'); // Tools

        $current_user = wp_get_current_user();
        if ( 3 != $current_user->ID ) :
            remove_menu_page( 'users.php' );
            remove_menu_page( 'edit.php?post_type=cuenta' );
            remove_menu_page( 'edit.php?post_type=registro' );
        endif;

    endif;
}
add_action( 'admin_menu', 'pb_remove_menu_items' );


/**
* CUSTOM FUNCTIONS
*/

/* Clientes */
add_action( 'add_meta_boxes', 'clientes_custom_metabox' );
function clientes_custom_metabox(){
    add_meta_box( 'clientes_meta', 'Información cliente', 'display_clientes_atributos', 'clientes', 'advanced', 'default');
}

function display_clientes_atributos( $clientes ){
    $nivel      = esc_html( get_post_meta( $clientes->ID, 'clientes_nivel', true ) );
    $correo     = esc_html( get_post_meta( $clientes->ID, 'clientes_correo', true ) );
    $cel        = esc_html( get_post_meta( $clientes->ID, 'clientes_cel', true ) );
    $tel        = esc_html( get_post_meta( $clientes->ID, 'clientes_tel', true ) );
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
    $args = array(
        'post_type'         => 'product',
        'posts_per_page'    => -1,
        'orderby'           => 'title',
        'order'             => 'ASC'
    );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();
            $post_id        = get_the_ID();

            $modelo      = 'modelo' . $post_id;
            $piezas      = 'piezas' . $post_id;
            $precio      = 'precio' . $post_id;
            $total          = 'total' . $post_id;
            ${$modelo}   = esc_html( get_post_meta( $pedidos->ID, 'pedidos_modelo' . $post_id, true ) ); 
            ${$piezas}   = esc_html( get_post_meta( $pedidos->ID, 'pedidos_piezas' . $post_id, true ) );
            ${$precio}   = esc_html( get_post_meta( $pedidos->ID, 'pedidos_precio' . $post_id, true ) );
            ${$total}   = esc_html( get_post_meta( $pedidos->ID, 'pedidos_total' . $post_id, true ) );

        endwhile;
    }  wp_reset_postdata();

    $cliente        = esc_html( get_post_meta( $pedidos->ID, 'pedidos_cliente', true ) );
    $nivelCliente   = esc_html( get_post_meta( $pedidos->ID, 'pedidos_nivelCliente', true ) );
    $infoCliente    = esc_html( get_post_meta( $pedidos->ID, 'pedidos_infoCliente', true ) );
    $entrega  = esc_html( get_post_meta( $pedidos->ID, 'pedidos_entrega', true ) );
    $estatus  = esc_html( get_post_meta( $pedidos->ID, 'pedidos_estatus', true ) );
    $alerta   = esc_html( get_post_meta( $pedidos->ID, 'pedidos_alerta', true ) );
    $totalOrd = esc_html( get_post_meta( $pedidos->ID, 'pedidos_totalOrd', true ) );
    $totalPzs = esc_html( get_post_meta( $pedidos->ID, 'pedidos_totalPzs', true ) );
?>
    <table class="pb-custom-fields">
        <tr>
            <th colspan="2" class="padding-bottom-30">
                <label for="pedidos_totalOrd">Total de orden:</label>
                <input type="number" id="pedidos_totalOrd" name="pedidos_totalOrd" value="<?php echo $totalOrd; ?>" placeholder="0">
            </th>
            <th class="padding-bottom-30">
                <label for="pedidos_totalOrd">Total piezas:</label>
                <input type="number" id="pedidos_totalPzs" name="pedidos_totalPzs" value="<?php echo $totalPzs; ?>" placeholder="0">
            </th>
            <th class="padding-bottom-30">
                <label for="pedidos_entrega">Fecha de entrega:</label>
                <input type="date" id="pedidos_entrega" name="pedidos_entrega" value="<?php echo $entrega; ?>">
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <label for="pedidos_cliente">Cliente:</label>
                <input type="text" id="pedidos_cliente" name="pedidos_cliente" value="<?php echo $cliente; ?>">
            </th>
            <th colspan="2">
                <label for="pedidos_nivelCliente">Nivel cliente:</label>
                <select name="pedidos_nivelCliente" id="pedidos_nivelCliente" required>
                    <option value=""></option>
                    <option value="Normal" <?php selected($nivelCliente, 'Normal'); ?>>Normal</option>
                    <option value="Plata" <?php selected($nivelCliente, 'Plata'); ?>>Plata</option>
                    <option value="Oro" <?php selected($nivelCliente, 'Oro'); ?>>Oro</option>
                </select><br>               
            </th>
        </tr>
        <tr>
            <th colspan="4" class="padding-bottom-30">
                <label for="pedidos_infoCliente">Información cliente:</label>
                <textarea type="text" id="pedidos_infoCliente" name="pedidos_infoCliente"><?php echo $infoCliente; ?></textarea>
            </th>
        </tr>
        <tr>
            <th colspan="2" class="padding-bottom-30">
                <label for="pedidos_estatus">Estatus:</label>
                <select name="pedidos_estatus" id="pedidos_estatus" required>
                    <option value=""></option>
                    <option value="Abierto" <?php selected($estatus, 'Abierto'); ?>>Abierto</option>
                    <option value="Cerrado" <?php selected($estatus, 'Cerrado'); ?>>Cerrado</option>
                </select><br>               
            </th>
            <th colspan="2" class="padding-bottom-30">
                <label for="pedidos_alerta">¿Cuántos días antes se te notifica?:</label>
                <input type="number" id="pedidos_alerta" name="pedidos_alerta" value="<?php echo $alerta; ?>" placeholder="0">
            </th>
        </tr>
        <?php     
        $args = array(
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC'
        );
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) {
            while ( $loop->have_posts() ) : $loop->the_post();
                $post_id        = get_the_ID();
                $productName    = get_the_title( $post_id );

                $modelo = ${'modelo' . $post_id};
                $piezas = ${'piezas' . $post_id};
                $precio = ${'precio' . $post_id};
                $total = ${'total' . $post_id}; ?>
                <tr>
                    <th>
                        <input type="text" name="pedidos_modelo<?php echo $post_id; ?>" value="<?php echo $modelo; ?>" placeholder="<?php echo $productName; ?>">
                    </th>
                    <th>
                        <input type="number" min="0" name="pedidos_piezas<?php echo $post_id; ?>" value="<?php echo $piezas; ?>" placeholder="0">
                    </th>
                    <th>
                        <input type="number" min="0" name="pedidos_precio<?php echo $post_id; ?>" value="<?php echo $precio; ?>" placeholder="0">
                    </th>
                    <th>
                        <input type="number" min="0" name="pedidos_total<?php echo $post_id; ?>" value="<?php echo $total; ?>" placeholder="0">
                    </th>
                </tr>  

            <?php endwhile;
        }  wp_reset_postdata(); ?>
    </table>
<?php }

add_action( 'save_post', 'pedidos_save_metas', 10, 2 );
function pedidos_save_metas( $idpedidos, $pedidos ){
    if ( $pedidos->post_type == 'pedidos' ){
        if ( isset( $_POST['pedidos_cliente'] ) ){
            update_post_meta( $idpedidos, 'pedidos_cliente', $_POST['pedidos_cliente'] );
        }
        if ( isset( $_POST['pedidos_nivelCliente'] ) ){
            update_post_meta( $idpedidos, 'pedidos_nivelCliente', $_POST['pedidos_nivelCliente'] );
        }
        if ( isset( $_POST['pedidos_infoCliente'] ) ){
            update_post_meta( $idpedidos, 'pedidos_infoCliente', $_POST['pedidos_infoCliente'] );
        }
        if ( isset( $_POST['pedidos_entrega'] ) ){
            update_post_meta( $idpedidos, 'pedidos_entrega', $_POST['pedidos_entrega'] );
        }
        if ( isset( $_POST['pedidos_estatus'] ) ){
            update_post_meta( $idpedidos, 'pedidos_estatus', $_POST['pedidos_estatus'] );
        }
        if ( isset( $_POST['pedidos_alerta'] ) ){
            update_post_meta( $idpedidos, 'pedidos_alerta', $_POST['pedidos_alerta'] );
        }
        if ( isset( $_POST['pedidos_totalOrd'] ) ){
            update_post_meta( $idpedidos, 'pedidos_totalOrd', $_POST['pedidos_totalOrd'] );
        }
        if ( isset( $_POST['pedidos_totalPzs'] ) ){
            update_post_meta( $idpedidos, 'pedidos_totalPzs', $_POST['pedidos_totalPzs'] );
        }
        $args = array(
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC'
        );
        $loop = new WP_Query( $args );
        $i = 1;
        if ( $loop->have_posts() ) {
            while ( $loop->have_posts() ) : $loop->the_post();
                $post_id        = get_the_ID();
                $productName    = get_the_title( $post_id ); 

                if ( isset( $_POST['pedidos_piezas' . $post_id] ) ){
                    update_post_meta( $idpedidos, 'pedidos_piezas' . $post_id, $_POST['pedidos_piezas' . $post_id] );
                }
                if ( isset( $_POST['pedidos_modelo' . $post_id] ) ){
                    update_post_meta( $idpedidos, 'pedidos_modelo' . $post_id, $_POST['pedidos_modelo' . $post_id] );
                }
                if ( isset( $_POST['pedidos_precio' . $post_id] ) ){
                    update_post_meta( $idpedidos, 'pedidos_precio' . $post_id, $_POST['pedidos_precio' . $post_id] );
                }
                if ( isset( $_POST['pedidos_total' . $post_id] ) ){
                    update_post_meta( $idpedidos, 'pedidos_total' . $post_id, $_POST['pedidos_total' . $post_id] );
                }
            endwhile;
        }  wp_reset_postdata();
    }
}

/* Materiales */
add_action( 'add_meta_boxes', 'materiales_custom_metabox' );
function materiales_custom_metabox(){
    add_meta_box( 'materiales_meta', 'Información material', 'display_materiales_atributos', 'materiales', 'advanced', 'default');
}

function display_materiales_atributos( $materiales ){
    $cantidad      = esc_html( get_post_meta( $materiales->ID, 'materiales_cantidad', true ) );
    $presentacion  = esc_html( get_post_meta( $materiales->ID, 'materiales_presentacion', true ) );
?>
    <table class="pb-custom-fields">
        <tr>
            <th>
                <label for="materiales_cantidad">Cantidad:</label>
                <input type="number" min="0" id="materiales_cantidad" name="materiales_cantidad" value="<?php echo $cantidad; ?>" required>
            </th>
            <th>
                <label for="materiales_presentacion">Presentación:</label>
                <input type="number" id="materiales_presentacion" name="materiales_presentacion" value="<?php echo $presentacion; ?>" placeholder="Pliego, kg., lt., etc." required>
            </th>
        </tr>
    </table>
<?php }

add_action( 'save_post', 'materiales_save_metas', 10, 2 );
function materiales_save_metas( $idmateriales, $materiales ){
    if ( $materiales->post_type == 'materiales' ){
        if ( isset( $_POST['materiales_cantidad'] ) ){
            update_post_meta( $idmateriales, 'materiales_cantidad', $_POST['materiales_cantidad'] );
        }
        if ( isset( $_POST['materiales_presentacion'] ) ){
            update_post_meta( $idmateriales, 'materiales_presentacion', $_POST['materiales_presentacion'] );
        }
    }
}


/* Contabilidad - cuenta */
add_action( 'add_meta_boxes', 'cuenta_custom_metabox' );
function cuenta_custom_metabox(){
    add_meta_box( 'cuenta_meta', 'Información cuenta', 'display_cuenta_atributos', 'cuenta', 'advanced', 'default');
}

function display_cuenta_atributos( $cuenta ){
    $tipo       = esc_html( get_post_meta( $cuenta->ID, 'cuenta_tipo', true ) );
    $cantidad   = esc_html( get_post_meta( $cuenta->ID, 'cuenta_cantidad', true ) );
    $categoria  = esc_html( get_post_meta( $cuenta->ID, 'cuenta_categoria', true ) );
?>
    <table class="pb-custom-fields">
        <tr>
            <th>
                <label for="cuenta_tipo">Tipo:</label>
                <select name="cuenta_tipo" id="cuenta_tipo" required>
                    <option value="Ingreso" <?php selected($tipo, 'Ingreso'); ?>>Ingreso</option>
                    <option value="Egreso" <?php selected($tipo, 'Egreso'); ?>>Egreso</option>
                </select><br>               
            </th>
            <th>
                <label for="cuenta_cantidad">Cantidad:</label>
                <input type="number" min="0" id="cuenta_cantidad" name="cuenta_cantidad" value="<?php echo $cantidad; ?>" required>
            </th>
            <th>
                <label for="cuenta_categoria">Categoria:</label>
                <select name="cuenta_categoria" id="cuenta_categoria" required>
                    <option value="Piñatas" <?php selected($categoria, 'Piñatas'); ?>>Piñatas</option>
                    <option value="Pago" <?php selected($categoria, 'Pago'); ?>>Pago</option>
                    <option value="Materiales" <?php selected($categoria, 'Materiales'); ?>>Materiales</option>
                    <option value="Servicios" <?php selected($categoria, 'Servicios'); ?>>Servicios</option>
                    <option value="Salarios" <?php selected($categoria, 'Salarios'); ?>>Salarios</option>
                    <option value="Viveres" <?php selected($categoria, 'Viveres'); ?>>Viveres</option>
                    <option value="Otros" <?php selected($categoria, 'Otros'); ?>>Otros</option>
                </select><br>               
            </th>
        </tr>
    </table>
<?php }

add_action( 'save_post', 'cuenta_save_metas', 10, 2 );
function cuenta_save_metas( $idcuenta, $cuenta ){
    if ( $cuenta->post_type == 'cuenta' ){
        if ( isset( $_POST['cuenta_tipo'] ) ){
            update_post_meta( $idcuenta, 'cuenta_tipo', $_POST['cuenta_tipo'] );
        }
        if ( isset( $_POST['cuenta_cantidad'] ) ){
            update_post_meta( $idcuenta, 'cuenta_cantidad', $_POST['cuenta_cantidad'] );
        }
        if ( isset( $_POST['cuenta_categoria'] ) ){
            update_post_meta( $idcuenta, 'cuenta_categoria', $_POST['cuenta_categoria'] );
        }
    }
}

/* Contabilidad - registros */
add_action( 'add_meta_boxes', 'registro_custom_metabox' );
function registro_custom_metabox(){
    add_meta_box( 'registro_meta', 'Información registro', 'display_registro_atributos', 'registro', 'advanced', 'default');
}

function display_registro_atributos( $registro ){
    $ingreso    = esc_html( get_post_meta( $registro->ID, 'registro_ingreso', true ) );
    $egreso     = esc_html( get_post_meta( $registro->ID, 'registro_egreso', true ) );
    $total      = esc_html( get_post_meta( $registro->ID, 'registro_total', true ) );
?>
    <table class="pb-custom-fields">
        <tr>
            <th>
                <label for="registro_ingreso">Ingreso:</label>
                <input type="number" min="0" id="registro_ingreso" name="registro_ingreso" value="<?php echo $ingreso; ?>" required>
            </th>
            <th>
                <label for="registro_egreso">Egreso:</label>
                <input type="number" min="0" id="registro_egreso" name="registro_egreso" value="<?php echo $egreso; ?>" required>
            </th>
            <th>
                <label for="registro_total">Total:</label>
                <input type="number" id="registro_total" name="registro_total" value="<?php echo $total; ?>" required>
            </th>
        </tr>
    </table>
<?php }

add_action( 'save_post', 'registro_save_metas', 10, 2 );
function registro_save_metas( $idregistro, $registro ){
    if ( $registro->post_type == 'registro' ){
        if ( isset( $_POST['registro_ingreso'] ) ){
            update_post_meta( $idregistro, 'registro_ingreso', $_POST['registro_ingreso'] );
        }
        if ( isset( $_POST['registro_egreso'] ) ){
            update_post_meta( $idregistro, 'registro_egreso', $_POST['registro_egreso'] );
        }
        if ( isset( $_POST['registro_total'] ) ){
            update_post_meta( $idregistro, 'registro_total', $_POST['registro_total'] );
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
        wp_redirect('#cliente_creado');
    }
}

/* Editar pedido */
add_action ('template_redirect', 'redirect_editcliente');
function redirect_editcliente() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditCliente'] ) ) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        wp_redirect($actual_link . '#cliente_actualizado');
    }
}

/* Nuevo pedido */
add_action ('template_redirect', 'redirect_pedido');
function redirect_pedido() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitPedido'] ) ) {
        wp_redirect('#pedido_creado');
    }
}

/* Editar pedido */
add_action ('template_redirect', 'redirect_editpedido');
function redirect_editpedido() {
    if ( ('POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditPedido'] ) ) || ('POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditAlerta'] ) ) ) {
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


/* Actualizar stock */
add_action ('template_redirect', 'redirect_stock');
function redirect_stock() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitStock'] ) ) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        wp_redirect($actual_link . '#stock_actualizado');
    }
}

/* Nuevo material */
add_action ('template_redirect', 'redirect_material');
function redirect_material() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitMaterial'] ) ) {
        wp_redirect('#material_creado');
    }
}
/* Editar material */
add_action ('template_redirect', 'redirect_editmaterial');
function redirect_editmaterial() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditMaterial'] ) ) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        wp_redirect($actual_link . '#material_actualizado');
    }
}
/* Solicitar material */
add_action ('template_redirect', 'redirect_materialsolic');
function redirect_materialsolic() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitMaterialSolic'] ) ) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        wp_redirect($actual_link . '#material_solicitado');
    }
}
/* Nuevo ingreso */
add_action ('template_redirect', 'redirect_ingreso');
function redirect_ingreso() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitIngreso'] ) ) {
        wp_redirect('#ingreso_creado');
    }
}
/* Nuevo egreso */
add_action ('template_redirect', 'redirect_egreso');
function redirect_egreso() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEgreso'] ) ) {
        wp_redirect('#egreso_creado');
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
    $columns['pedidos_total']  = __( 'Total', 'pbolita' );
    $columns['pedidos_estatus'] = __( 'Estatus', 'pbolita' );

    return $columns;
}

add_action( 'manage_pedidos_posts_custom_column' , 'custom_pedidos_column', 10, 2 );
function custom_pedidos_column( $column, $post_id ) {
    switch ( $column ) {
        case 'pedidos_total' :
            $nivelCliente  = get_post_meta( $post_id, 'pedidos_nivelCliente', true );
            $totalPzs  = get_post_meta( $post_id, 'pedidos_totalPzs', true );
            $totalOrd  = get_post_meta( $post_id, 'pedidos_totalOrd', true );
            if( $totalOrd != "")
                echo $nivelCliente . '</br>' . $totalPzs . 'pzs.</br>$' . $totalOrd;
            else
                echo "-";
            break;
        case 'pedidos_estatus' :
            $estatus        = get_post_meta( $post_id, 'pedidos_estatus', true );
            $alerta         = get_post_meta( $post_id, 'pedidos_alerta', true );
            $entregaOrg     = get_post_meta( $post_id, 'pedidos_entrega', true );
            $alertActive    = date("Y-m-d", strtotime($entregaOrg . '- ' . $alerta . ' days'));
            /* Fecha en español */
            setlocale(LC_ALL,"es_ES");
            $alertActive = strftime("%d/%B/%Y", strtotime($alertActive));
            $entregaOrg = strftime("%d/%B/%Y", strtotime($entregaOrg));
            if( $estatus != "")
                echo $estatus . '</br>Alerta: ' . $alerta . ' días antes el ' . $alertActive . '</br>Entrega: ' . $entregaOrg;
            else
                echo "-";
            break;
    }
}


/* Contabilidad */
add_filter( 'manage_cuenta_posts_columns', 'set_custom_edit_cuenta_columns' );
function set_custom_edit_cuenta_columns($columns) {
    $columns['cuenta_tipo']  = __( 'Tipo', 'pbolita' );
    $columns['cuenta_cantidad'] = __( 'Cantidad', 'pbolita' );
    $columns['cuenta_categoria'] = __( 'Categoría', 'pbolita' );
    $columns['cuenta_fecha'] = __( 'Fecha', 'pbolita' );

    return $columns;
}

add_action( 'manage_cuenta_posts_custom_column' , 'custom_cuenta_column', 10, 2 );
function custom_cuenta_column( $column, $post_id ) {
    switch ( $column ) {
        case 'cuenta_tipo' :
            $tipo  = get_post_meta( $post_id, 'cuenta_tipo', true );
            if( $tipo != "")
                echo $tipo;
            else
                echo "-";
            break;
        case 'cuenta_cantidad' :
            $cantidad  = get_post_meta( $post_id, 'cuenta_cantidad', true );
            if( $cantidad != "")
                echo $cantidad;
            else
                echo "-";
            break;
        case 'cuenta_categoria' :
            $categoria  = get_post_meta( $post_id, 'cuenta_categoria', true );
            if( $categoria != "")
                echo $categoria;
            else
                echo "-";
            break;
        case 'cuenta_fecha' :
            echo get_the_date("d/m/Y");
            break;
    }
}