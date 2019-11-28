<?php

namespace Wp_Motive;

/**
 * This class logs information submitted by the plugin.
  * @link       http://behstant.com/blog
 * @since      1.0.0
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Logger
{
    private $filename = "error.log";
    private $path = "";
    private $file = null;
    private $dateFormat = "d-M-Y h:i:s A";

    public function __construct( $path = null ) {
        // Initialize values
        $this->path = $path == null ? plugin_dir_path( __DIR__ ) . "log" : $path;
        $this->createFileStream();
    }

    /**
     *
     *  Create a new File Stream Resource in append mode.
     * @since 1.0.0
     * @author Israel Barragan (Reedyseth)
     *
     */
    private function createFileStream(){
        $ruta = $this->path . "/";
        if( is_writable( $ruta ) ){
            $this->file = fopen($ruta . "/" . $this->filename, "a");
        }
        else {
            return false;
        }
    }

    public function log( $message="" ){
        $date = date( $this->dateFormat );
        $result = fputs( $this->file, "[ {$date} ] - " . $message );

        return $result===false ? false : true;
    }

    public function closeStream(){
        fclose($this->file);
        clearstatcache();
    }
}