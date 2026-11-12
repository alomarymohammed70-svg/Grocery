<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'string'
    ];

    /**
     * الحصول على قيمة الإعداد
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * حفظ قيمة الإعداد
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * الحصول على كل إعدادات النظام
     */
    public static function getAllSettings()
    {
        $defaults = [
            'store_name' => 'نظام إدارة البقالة',
            'store_phone' => '',
            'store_email' => '',
            'store_address' => '',
            'currency' => 'SAR',
            'date_format' => 'DD/MM/YYYY',
            'time_format' => '12h',
            'language' => 'ar',
            'tax_rate' => '15.00',
            'expiry_warning_days' => '30',
            'low_stock_threshold' => '10'
        ];

        $settings = [];
        foreach ($defaults as $key => $defaultValue) {
            $settings[$key] = self::get($key, $defaultValue);
        }
        
        return $settings;
    }

    /**
     * حفظ إعدادات النظام
     */
    public static function saveAllSettings($data)
    {
        foreach ($data as $key => $value) {
            self::set($key, $value);
        }
        return true;
    }
}