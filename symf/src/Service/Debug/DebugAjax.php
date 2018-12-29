<?php
namespace App\Service\Debug;

class DebugAjax {
    
    public function debug(string $filename, $var) {
        file_put_contents('debug_ajax/' . $filename, var_export($var, true));
    }
}