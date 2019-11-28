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
    public function run()
    {
        $logger = new Logger();
        $logger->log("Run() function executed.!!\n");
    }
}