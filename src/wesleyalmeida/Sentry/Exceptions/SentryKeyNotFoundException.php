<?php
/**
 * Author: Wesley
 * Date: 07-Jan-15
 * Time: 16:04
 */

namespace Wesleyalmeida\Sentry\Exceptions;

use Exception;

class SentryKeyNotFoundException extends Exception{

    public function __construct($message = "", $code = 400, Exception $previous = null){

        if($message == "" ){
            $message = "Unable to retrieve Sentry user roles from the Session. The session probably expired";
        }

        parent::__construct($message, $code, $previous);
    }

    public function __toString(){
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}