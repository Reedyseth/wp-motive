<?php
namespace Wp_Motive;
/**
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @since      10-Dic-2019
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * This class define the functionality of the Plugin in the Public area.
 *
 * @class Wp_Motive
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_Public extends Wp_Motive_Controller
{
    protected $hooks = null;
    private $slug = "";
    private $resources = null;

    public function __construct($slug, $plugin_url, $plugin_version)
    {
        $this->hooks = new Wp_Motive_Hooks();
        $this->resources = new Wp_Motive_Resources($plugin_url, $plugin_version);
        $this->make_public_hooks();
        $this->hooks->load_hooks();
        $this->slug = $slug;
    }

    private function make_public_hooks()
    {
        $this->hooks->add_actions("wp_enqueue_scripts", $this->resources, "enqueue_public_scripts");
        $this->hooks->add_actions("wp_enqueue_scripts", $this->resources, "enqueue_public_styles");

        $this->hooks->add_actions("wp_ajax_nopriv_wp_motive_update_options", $this, "update_options");
        $this->hooks->add_actions("wp_ajax_nopriv_wp_motive_cache_data", $this, "cache_endpoint_data");
        $this->hooks->add_actions("wp_ajax_nopriv_wp_motive_load_cache_data", $this, "reload_cache_data");
        $this->hooks->add_actions("wp_ajax_nopriv_wp_motive_loaded_table_time", $this, "save_loaded_table_time");
    }

}
