<?php
namespace Wp_Motive;
/**
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @version    1.0.0
 * @since      29-Nov-2019
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 * @link       http://behstant.com/blog/
 */
class Wp_Motive_i18n {
    private $localize;
    /**
     * Load the plugin text domain for translation.
     *                                                                                                                                           * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'wp-motive',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );
    }

    /**
     * Translate text to send it to Javascript. Calling this method from a constructor behaves not correctly.
     * Looks like when the constructor method call this the global variable $i10n is null when call on
     * get_translations_for_domain() defined on /wpdir/wp-includes/l10n.php
     *
     * @since 12-Dic-2019
     * @version 1.0.0
     * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>
     *
     */
    public function define_localization()
    {
//        $log = new Wp_Motive_Logger();
        $this->localize = array(
            "ajax_url" => admin_url("admin-ajax.php"),
            "message_no_data" => __( 'No data to show' ,'wp-motive'),
            "message_cli_loaded" => __( 'Data force loaded from WP CLI.' ,'wp-motive'),
            "message_endpoint_loaded" => __( 'Data loaded from endpoint.' ,'wp-motive'),
            "message_cache_loaded" => __( 'Data loaded from cached.' ,'wp-motive'),
            "message_limit_loaded" => __( "You can't make a request to the endpoint until the time limit"
                ." is reached, information loaded from cached." ,'wp-motive'),
        );
//        $log->log( print_r( $this->localize, true ) );
    }
    public function get_localize()
    {
        return $this->localize;
    }
}
