<?php
/**
 * Part of Aplazo Module
 * Author - Aplazo
 * Developer
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package Aplazo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_Aplazo_Log
 */
class WC_Aplazo_Log
{

	/**
	 * Log
	 * @var WC_Aplazo_Log
	 */
	public $logger;

	/**
	 * Id
	 *
	 * @var WC_Aplazo_Log::$id
	 */
	public $id;

	/**
	 * DebugLog
	 *
	 * @var WC_Aplazo_Log::$debug_mode
	 */
	public $debug_mode;
    /**
     * Static instance
     *
     * @var WC_Aplazo_Log
     */
    private static $instance = null;

    /**
     * @param $id
     * @param $debug_mode
     */
	public function __construct($id = false, $debug_mode = false ) {
		$this->debug_mode = $debug_mode;
        $this->id = $id;
		return $this->init_log();
	}

	/**
	 * Init_log function
	 *
	 * @return WC_Logger|null
	 */
	public function init_log() {
		if ( class_exists( 'WC_Logger' )) {
            $this->logger = wc_get_logger();
			return $this->logger;
        } else {
            return null;
        }
	}

    /**
     * @param $id
     * @param $debug_mode
     * @return WC_Aplazo_Log|self|null
     */
	public static function init_aplazo_log( $id = null, $debug_mode = false ) {
        if ( null === self::$instance ) {
            self::$instance = new self($id, $debug_mode);
        }
        return self::$instance;
	}

	/**
	 * Write_log function
	 *
	 * @param [type] $function .
	 * @param [type] $message .
	 * @return void
	 */
	public function write_log( $function, $message ) {
		if ( ! empty( $this->debug_mode ) ) {
            if(is_array($message)){
                $this->logger->$function(wc_print_r( $message, true ), array( 'source' => $this->id ));
            } else {
                $this->logger->$function($message, array( 'source' => $this->id ));
            }
		}
	}

	/**
	 * Set_id function
	 *
	 * @param [type] $id .
	 * @return void
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}
}
