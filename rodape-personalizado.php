<?php
/*
 Plugin Name: Rodapé Personalizado
 Plugin URI: http://meusite.com
 Description: Um plugin simples para adicionar uma mensagem personalizada ao rodapé do site.
 Version: 1.0
 Author: Seu Nome
 Author URI: http://seusite.com
 Text Domain: rodape-personalizado
 Domain Path: /languages
*/

// Evita o acesso direto ao arquivo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Carrega as traduções
function rp_load_textdomain() {
    load_plugin_textdomain( 'rodape-personalizado', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'rp_load_textdomain' );

// Adiciona o menu de configurações
function rp_add_admin_menu() {
    add_options_page(
        __( 'Rodapé Personalizado', 'rodape-personalizado' ),
        __( 'Rodapé Personalizado', 'rodape-personalizado' ),
        'manage_options',
        'rodape_personalizado',
        'rp_options_page'
    );
}
add_action( 'admin_menu', 'rp_add_admin_menu' );

// Registra as configurações
function rp_register_settings() {
    register_setting( 'rp_options_group', 'rp_footer_message' );
}
add_action( 'admin_init', 'rp_register_settings' );

// Cria a página de configurações
function rp_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e( 'Rodapé Personalizado', 'rodape-personalizado' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'rp_options_group' );
            do_settings_sections( 'rp_options_group' );
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Mensagem do Rodapé', 'rodape-personalizado' ); ?></th>
                    <td>
                        <input type="text" name="rp_footer_message" value="<?php echo esc_attr( get_option( 'rp_footer_message' ) ); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Exibe a mensagem do rodapé
function rp_footer_message() {
    $message = get_option( 'rp_footer_message' );
    if ( ! empty( $message ) ) {
        echo '<p class="rodape-personalizado">' . esc_html( $message ) . '</p>';
    }
}
add_action( 'wp_footer', 'rp_footer_message' );
