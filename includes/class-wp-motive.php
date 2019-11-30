<?php
namespace Wp_Motive;
/**
 * This class define the core functionality of the Plugin.
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * @class Wp_Motive
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive
{
    protected $version;
    protected $plugin_version;

    public function __construct()
    {
        if( defined( PLUGIN_NAME_VERSION ) ){
            $this->plugin_version = PLUGIN_NAME_VERSION;
        }
        else {
            $this->plugin_version = "1.0.0";
        }
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    public function run()
    {
        $logger = new Wp_Motive_Logger();
        $logger->log("Run() function executed.!!\n");
    }

    private function load_dependencies()
    {

    }
    private function set_locale()
    {
        $plugin_i18n = new Wp_Motive_i18n();
    }
    private function define_admin_hooks()
    {

    }
    private function define_public_hooks()
    {

    }
}