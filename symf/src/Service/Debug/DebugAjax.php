<?php
namespace App\Service\Debug;

class DebugAjax {
    
    public function debug(string $filename, $var, bool $fileAppend = false) {
        $append = ($fileAppend) ? FILE_APPEND : 0;
        
        file_put_contents('debug_ajax/' . $filename, var_export($var, true), $append);
    }
}