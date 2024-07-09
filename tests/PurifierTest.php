<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\Sanitizer;

class HtmlPurifiertest extends WebTestCase {
    public function testPurifier(){
        $xss = '<script>alert("XSS")</script>';
        
        $sanitizer = new Sanitizer();
        $cleaned = $sanitizer->sanitizeHtml($xss);
        $this->assertSame($cleaned, '');
    }
}
