<?php

namespace Workdo\VCard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CardAppinfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'playstore_id',
        'appstore_id',
        'variant',
        'is_enabled',
        'created_by'
    ];
    private static $appInfo = null;
    private static $flagApps = false;
    protected $table = 'card_app_info';
    protected static function newFactory()
    {
        return \Workdo\VCard\Database\factories\CardAppinfoFactory::new();
    }
    public static function cardAppData($id)
    {
        if (self::$appInfo == null) {
            if (self::$flagApps === false) {

                $appDetail = CardAppinfo::where('business_id', $id)->first();
                self::$appInfo = $appDetail;
                self::$flagApps = true;
            }
        }
        return self::$appInfo;

    }
}
