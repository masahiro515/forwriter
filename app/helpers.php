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
