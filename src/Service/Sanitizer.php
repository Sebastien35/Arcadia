<?php

namespace App\Service;

class Sanitizer
{   
    public function __construct()
    {
    }
    public function sanitizeHtml($html) {
        // Define allowed tags and attributes
        $allowedTags = '<p><a><strong><em><u><ul><ol><li><br>';
        $allowedAttributes = array(
            'a' => 'href,title',
        );
    
        // Remove disallowed tags and attributes
        $html = strip_tags($html, $allowedTags);
        $html = preg_replace_callback('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i', function ($matches) use ($allowedAttributes) {
            $tag = strtolower($matches[1]);
            if (!isset($allowedAttributes[$tag])) {
                return '';
            }
            // Check for allowed attributes
            $attributes = '';
            $pattern = '/\s*([^\s=]+)(?:=(?:"([^"]*)"|\'([^\']*)\'|([^"\'\s]*)))?/';
            preg_match_all($pattern, $matches[0], $attrMatches, PREG_SET_ORDER);
            foreach ($attrMatches as $attrMatch) {
                $attrName = strtolower($attrMatch[1]);
                if (in_array($attrName, explode(',', $allowedAttributes[$tag]))) {
                    $attrValue = isset($attrMatch[2]) ? $attrMatch[2] : (isset($attrMatch[3]) ? $attrMatch[3] : (isset($attrMatch[4]) ? $attrMatch[4] : ''));
                    $attributes .= ' ' . $attrName . '="' . htmlspecialchars($attrValue) . '"';
                }
            }
            return '<' . $matches[1] . $attributes . (empty($matches[2]) ? '>' : ' />');
        }, $html);
    
        return $html;
    }
}
