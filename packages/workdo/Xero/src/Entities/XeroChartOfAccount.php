<?php

namespace Workdo\Xero\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Workdo\Account\Entities\ChartOfAccountType;
use Workdo\Account\Entities\ChartOfAccountSubType;

class XeroChartOfAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'chartofaccount_id',
        'xero_id',
        'xero_code',
        'workspace',
        'created_by',
    ];

   

    public static function gettype($type)
    {
        if($type=="ASSET")
        {
            $type=ChartOfAccountType::where('name','Assets')->where('created_by',creatorId())->first();
        }
        elseif($type=="EQUITY")
        {
            $type=ChartOfAccountType::where('name','Equity')->where('created_by',creatorId())->first();
        }
        elseif($type=="EXPENSE")
        {
            $type=ChartOfAccountType::where('name','Expenses')->where('created_by',creatorId())->first();
        }
        elseif($type=="LIABILITY")
        {
            $type=ChartOfAccountType::where('name','Liabilities')->where('created_by',creatorId())->first();
        }
        elseif($type=="REVENUE")
        {
            $type=ChartOfAccountType::where('name','Income')->where('created_by',creatorId())->first();
        }
        else
        {
            $type=ChartOfAccountType::where('name',$type)->where('created_by',creatorId())->first();
            if($type==null)
            {
                $type=New ChartOfAccountType();
                $type->name=$type;
                $type->created_by=creatorId();
                $type->save();
            }
        }
        return $type->id;
    }

    public static function getsubtype($type,$subtype)
    {
        if($subtype=="BANK")
        {
            $subtype=ucwords($subtype);
            $subtype=ChartOfAccountSubType::where('name',$subtype)->first();

            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name='Bank';
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="CURRENT")
        {
            $subtype=ChartOfAccountSubType::where('name','Current Asset')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Current Asset";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="CURRLIAB")
        {
            $subtype=ChartOfAccountSubType::where('name','Current Liabilities')->orWhere('name','Current Liability')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Current Liability";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="DEPRECIATN")
        {
            $subtype=ChartOfAccountSubType::where('name','Depreciation')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Depreciation";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="DIRECTCOSTS")
        {
            $subtype=ChartOfAccountSubType::where('name','Direct Costs')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Direct Costs";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="EQUITY")
        {
            $subtype=ChartOfAccountSubType::where('name','Equity')->orWhere('name','Owners Equity')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Equity";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="EXPENSE")
        {
            $subtype=ChartOfAccountSubType::where('name','Expense')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Expense";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="FIXED")
        {
            $subtype=ChartOfAccountSubType::where('name','Fixed Asset')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Fixed Asset";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="INVENTORY")
        {
            $subtype=ChartOfAccountSubType::where('name','Inventory Asset')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Inventory Asset";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="LIABILITY")
        {
            $subtype=ChartOfAccountSubType::where('name','Liability')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Liability";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="NONCURRENT")
        {
            $subtype=ChartOfAccountSubType::where('name','Non-current Asset')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Non-current Asset";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="OTHERINCOME")
        {
            $subtype=ChartOfAccountSubType::where('name','Other Income')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Other Income";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="OVERHEADS")
        {
            $subtype=ChartOfAccountSubType::where('name','Overhead')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Overhead";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="PREPAYMENT")
        {
            $subtype=ChartOfAccountSubType::where('name','Prepayment')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Prepayment";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="REVENUE")
        {
            $subtype=ChartOfAccountSubType::where('name','Revenue')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Revenue";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="SALES")
        {
            $subtype=ChartOfAccountSubType::where('name','Sale')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Sale";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        elseif($subtype=="TERMLIAB")
        {
            $subtype=ChartOfAccountSubType::where('name','Non-current Liability')->where('type',$type)->first();
            if($subtype==null)
            {
                $subtype=New ChartOfAccountSubType();
                $subtype->name="Non-current Liability";
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        else
        {
            if(isset($subtype))
            {
                $subtype=ucwords($subtype);
                $subtype=New ChartOfAccountSubType();
                $subtype->name=$subtype;
                $subtype->type=$type;
                $subtype->workspace = getActiveWorkSpace();
                $subtype->created_by = creatorId();
                $subtype->save();
            }
        }
        return $subtype->id;
    }
}
