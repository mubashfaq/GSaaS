<?php

namespace Workdo\QuickBooks\Entities;

use Workdo\Account\Entities\ChartOfAccountSubType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Workdo\Account\Entities\ChartOfAccount;
use Workdo\Account\Entities\ChartOfAccountType;

class QuickbookChartOfAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'chartofaccount_id',
        'quickbook_id',
        'workspace',
        'created_by',
    ];

  

    public static function gettype($type)
    {
        if($type=="Asset")
        {
            $type=ChartOfAccountType::where('name','Assets')->where('created_by',creatorId())->where('workspace',getActiveWorkSpace())->first();
        }
        elseif($type=="Equity")
        {
            $type=ChartOfAccountType::where('name','Equity')->where('created_by',creatorId())->where('workspace',getActiveWorkSpace())->first();
        }
        elseif($type=="Expense")
        {
            $type=ChartOfAccountType::where('name','Expenses')->where('created_by',creatorId())->where('workspace',getActiveWorkSpace())->first();
        }
        elseif($type=="Liability")
        {
            $type=ChartOfAccountType::where('name','Liabilities')->orWhere('name','Liability')->where('created_by',creatorId())->where('workspace',getActiveWorkSpace())->first();
        }
        elseif($type=="Revenue")
        {
            $type=ChartOfAccountType::where('name','Income')->where('created_by',creatorId())->where('workspace',getActiveWorkSpace())->first();
        }
        elseif($type=="Costs of Goods Sold")
        {
            $type=ChartOfAccountType::where('name','Costs of Goods Sold')->where('created_by',creatorId())->where('workspace',getActiveWorkSpace())->first();
        }
        else
        {
            $data=ChartOfAccountType::where('name',$type)->where('created_by',creatorId())->where('workspace',getActiveWorkSpace())->first();

            if($data==null)
            {
                $data=New ChartOfAccountType();
                $data->name=$type;
                $data->created_by=creatorId();
                $data->workspace=getActiveWorkSpace();
                $data->save();
            }
            if(isset($data) || !empty($data))
            {
                $type=$data;
            }
        }
        return $type->id;
    }

    public static function getsubtype($type,$subtype)
    {
        $data=ChartOfAccountSubType::class::where('name',$subtype)->where('type',$type)->first();

        if(!isset($data) && empty($data) )
        {
            $data       = new ChartOfAccountSubType();
            $data->name = $subtype;
            $data->type = $type;
            $data->workspace = getActiveWorkSpace();
            $data->created_by = creatorId();
            $data->save();
        }
        return $data->id;
    }
}
