<?php
namespace Wp_Motive;
/**
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @since      29-Nov-2019
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * Fired during plugin activation.
 *
 * This Class handles the hooks registrations.
 * It registers the hooks defined on $actions and $filters
 *
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_Hooks {
    private $actions = [];
    private $filters= [];

    /**
     * Wp_Motive_Hooks constructor.
     */
    public function __construct()
    {
    }

    /**
     *  Enqueue hooks to the $actions array.
     *
     * @since 29-Nov-2019
     * @version 1.0.0
     * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>
     *
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     */
    public function add_actions( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
        $this->actions[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );
    }
    /**
     *  Enqueue hooks to the $filters array.
     *
     * @since 29-Nov-2019
     * @version 1.0.0
     * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>
     *
     * @param $hook
     * @param $component
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     */
    public function add_filters( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
        $this->filters[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );
    }

    /**
     *
     *
     * @since 29-Nov-2019
     * @version 1.0.0
     * @author Israel Barragan (Reedyseth)
     *
     */
    public function load_hooks()
    {
        foreach( $this->actions as $action ){
            add_action( $action['hook'], array( $action['component'], $action['callback'] ),
                $action['priority'], $action['accepted_args'] );
        }
        foreach( $this->filters as $filter ){
            add_action( $filter['hook'], array( $filter['component'], $filter['callback'] ),
                $filter['priority'], $filter['accepted_args'] );
        }
    }
}