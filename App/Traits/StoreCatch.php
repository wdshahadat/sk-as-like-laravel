<?php

namespace App\Traits;

/**
 * StoreCatch
 */
trait StoreCatch
{
    public static $old = [];

    public static function old($old)
    {
        if ($old) {
            self::$old = $old;
        }
        return self::$old;
    }
}
