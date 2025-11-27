<?php

namespace App\Helpers;

class ContentFilter
{
    private static $badWords = [
        'anjing', 'babi', 'bangsat', 'brengsek', 'bodoh', 'goblok', 'tolol', 'idiot', 'kampret', 'kontol', 'memek', 'pepek', 'ngentot', 'fuck', 'shit', 'damn', 'bitch', 'asshole', 'stupid', 'moron', 'jancok', 'cuk', 'tai', 'setan', 'iblis', 'laknat', 'sialan', 'bajingan', 'keparat', 'monyet', 'kacung', 'budak', 'sampah', 'bangke', 'perek', 'pelacur', 'sundal', 'lonte'
    ];

    public static function filterContent($text)
    {
        $filteredText = $text;
        
        foreach (self::$badWords as $badWord) {
            $pattern = '/\b' . preg_quote($badWord, '/') . '\b/i';
            $replacement = str_repeat('*', strlen($badWord));
            $filteredText = preg_replace($pattern, $replacement, $filteredText);
        }
        
        return $filteredText;
    }
}