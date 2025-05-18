<?php
if (!function_exists('formatMinutes')) {
    function formatMinutes(?int $minutes): string
    {
        if (is_null($minutes) || $minutes === 0) return '未計測';
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return ($hours ? "{$hours}時間 " : '') . "{$mins}分";
    }
}


if (!function_exists('linkify')) {
    function linkify($text) {
        $pattern = '/(https?:\/\/[^\s<]+)/i';
        $replacement = '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>';
        return preg_replace($pattern, $replacement, e($text));
    }
}
