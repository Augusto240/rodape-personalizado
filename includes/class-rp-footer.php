<?php
// Evita o acesso direto ao arquivo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define a classe principal do plugin
class RP_Footer {

    // Inicializa o plugin
    public function init() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'wp_footer', array( $this, 'display_footer_message' ) );
    }

    // Adiciona o menu de configurações
    public function add_admin_menu() {
        add_options_page(
            __( 'Rodapé Personalizado', 'rodape-personalizado' ),
            __( 'Rodapé Personalizado', 'rodape-personalizado' ),
            'manage_options',
            'rodape_personalizado',
            array( $this, 'options_page' )
        );
    }

    // Registra as configurações
    public function register_settings() {
        register_setting( 'rp_options_group', 'rp_footer_message' );
    }

    // Cria a página de configurações
    public function options_page() {
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
    public function display_footer_message() {
        $message = get_option( 'rp_footer_message' );
        if ( ! empty( $message ) ) {
            echo '<p class="rodape-personalizado">' . esc_html( $message ) . '</p>';
        }
    }
}
