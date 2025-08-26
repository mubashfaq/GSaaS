<?php

namespace Workdo\VCard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessHour extends Model
{
    use HasFactory;

    private static $cardBusinessHourData = null;
    private static $cardflaghour = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];
    public static $days = [
        'sun' => 'Sunday',
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday',
    ];

    public static function cardBusinessHour($id)
    {
        if (self::$cardBusinessHourData == null) {
            if (self::$cardflaghour === false) {
                $business_hours = BusinessHour::where('business_id', $id)->first();
                self::$cardBusinessHourData = $business_hours;
                self::$cardflaghour = true;
            }
        }
        return self::$cardBusinessHourData;
    }
}
