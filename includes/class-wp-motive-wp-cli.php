<?php
namespace Wp_Motive;
/**
 * This class define the functionality of the Plugin for the WP CLI.
 * Only public methods are register as a sub commands. Private methods
 * are handle internally.
 *
 * @class Wp_Motive
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 * @link       http://behstant.com/blog
 */
class Wp_Motive_Wp_Cli
{
    public function reload( $args )
    {
        $valid_arguments = array( 'yes', 'no' );

        if( sizeof( $args ) > 1 ){
            \WP_CLI::error("Only 1 argument is allow.");
        }
        // Only yes|no values are allow
        if( in_array( strtolower( $args[0] ), $valid_arguments ) ) {

            if( 'yes' === $args[0] ){
                update_option( 'wp_motive_users_data_override', 'yes' );
                \WP_CLI::success( "[WP-Motive] Force Table Reload to 'yes'" );
            }
            elseif( 'no' === $args[0] ){
                update_option( 'wp_motive_users_data_override', 'yes' );
                \WP_CLI::success( "[WP-Motive] Force Table Reload to 'no'" );
            }
            else {
                \WP_CLI::line( "[WP-Motive] Nothing to do.!!" );
            }
        }
        else {
            \WP_CLI::error("Only 'yes' and 'no' values are allow.");
        }
    }
}
