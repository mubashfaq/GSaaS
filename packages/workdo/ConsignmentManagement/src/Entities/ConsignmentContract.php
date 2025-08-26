<?php

namespace Workdo\ConsignmentManagement\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Workdo\Account\Entities\Customer;

class ConsignmentContract extends Model
{
    protected $fillable = [
        'party_a',
        'party_b',
        'contract_type',
        'start_date',
        'end_date',
        'terms_and_conditions'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class , 'id' , 'party_a');
    }

    public function company()
    {
        return $this->hasOne(User::class , 'id' , 'party_b');
    }

    public static $contractType =[
        'Supply'  => 'Supply',
        'Purchase' => 'Purchase'
    ];
}
