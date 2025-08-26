<?php

namespace Workdo\VCard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    private static $cardappointmentData = null;
    private static $cardflagApp = false;
    protected $fillable = [
        'business_id',
        'content',
        'is_enabled',
        'created_by'
    ];

    protected $table="appoinments";
    public static function cardAppointmentData($id)
    {
        if (self::$cardappointmentData == null) {
            if (self::$cardflagApp === false) {
                $appointmentDetail = Appointment::where('business_id', $id)->first();
                self::$cardappointmentData = $appointmentDetail;
                self::$cardflagApp = true;
            }
        }
        return self::$cardappointmentData;

    }
}
