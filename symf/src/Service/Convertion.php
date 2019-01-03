<?php
namespace App\Service;

class Convertion {
    
   public function bytes2Mo(int $bytes, bool $round = false) : float {
       $mo = $bytes / pow(1024, 2);
       
       return ($round) ? round($mo, 2) : $mo ;
   }
}