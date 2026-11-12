<?php

if (!function_exists('getInitials')) {
    function getInitials($name)
    {
        if (empty($name)) return '';

        $names = explode(' ', $name);
        if (count($names) >= 2) {
            return mb_substr($names[0], 0, 1) . mb_substr($names[1], 0, 1);
        }

        return mb_substr($name, 0, 2);
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount)
    {
        return number_format($amount, 2) . ' ر.س';
    }
}
