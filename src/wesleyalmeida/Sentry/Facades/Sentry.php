<?php
/**
 * Author: Wesley
 * Date: 30-Dec-14
 * Time: 18:29
 */

namespace Wesleyalmeida\Sentry\Facades;

use Illuminate\Support\Facades\Facade;

class Sentry extends Facade {

    protected static function getFacadeAccessor() { return 'sentry'; }
}