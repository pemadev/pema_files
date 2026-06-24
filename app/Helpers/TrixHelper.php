<?php

namespace App\Helpers;

class TrixHelper
{
    /**
     * Clean Trix HTML content - remove empty tags and normalize
     */
    public static function clean($html)
    {
        if (empty($html)) {
            return '';
        }
        
        // Remove empty paragraphs from Trix
        $html = preg_replace('/<p><br><\/p>/', '', $html);
        $html = preg_replace('/<div><p><br><\/p><\/div>/', '', $html);
        
        // Remove leading/trailing whitespace
        $html = trim($html);
        
        // If only empty tags remain, return empty
        if (preg_replace('/<[^>]*>/', '', $html) === '') {
            return '';
        }
        
        return $html;
    }
    
    /**
     * Strip HTML tags for plain text display
     */
    public static function plainText($html, $limit = null)
    {
        $text = strip_tags($html);
        $text = html_entity_decode($text);
        $text = trim($text);
        
        if ($limit) {
            return Str::limit($text, $limit);
        }
        
        return $text;
    }
}
