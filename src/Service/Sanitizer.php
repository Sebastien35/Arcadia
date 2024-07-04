<?php

namespace App\Service;

use HTMLPurifier;
use HTMLPurifier_Config;

class Sanitizer
{   
    
    public function sanitizeHtml($cleanme) {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($cleanme);
    }
}
