<?php

namespace Workdo\Pos\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\Pos\Entities\Pos;
use App\Models\PosReturn;

use App\Models\Purchase;
use App\Models\Warehouse;
use App\Models\PosReturnPayment;
use App\Models\PurchaseReturnPayment;
use App\Models\PurchaseReturn;
use App\Models\WarehouseProduct;
use Carbon\Carbon;
use Workdo\ProductService\Entities\ProductService;
use DB ;
class ReportController extends Controller
{


    public function yearMonth()
    {

        $month[] = __('January');
        $month[] = __('February');
        $month[] = __('March');
        $month[] = __('April');
        $month[] = __('May');
        $month[] = __('June');
        $month[] = __('July');
        $month[] = __('August');
        $month[] = __('September');
        $month[] = __('October');
        $month[] = __('November');
        $month[] = __('December');

        return $month;
    }
    public function yearList()
    {
        $starting_year = date('Y', strtotime('-5 year'));
        $ending_year   = date('Y');

        foreach(range($ending_year, $starting_year) as $year)
        {
            $years[$year] = $year;
        }

        return $years;
    }



  
    
    




public function posDailyReport(Request $request)
{
    if(\Auth::user()->isAbleTo('report pos'))
    {
        $products = ProductService::where('created_by', '=', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        $products->prepend('All Product', 0);
        
        
        $brand = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->where('type', 3)
            ->get()
            ->pluck('name', 'id');
        $brand->prepend('All Brand', 0);
        
        $category = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->where('type', 0)
            ->get()
            ->pluck('name', 'id');
        $category->prepend('All Category', 0);
        
        $warehouse = Warehouse::where('created_by', '=', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        $warehouse->prepend('All Warehouse', 0);
        
        $customer = User::where('type', 'client')
            ->where('created_by', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        $customer->prepend('All Customer', 0);
        
        // Define date range
        if(!empty($request->start_date) && !empty($request->end_date))
        {
            $first_date = $request->start_date;
            $end_date = $request->end_date;
        }
        else
        {
            $first_date = date('Y-m-d', strtotime('today - 30 days'));
            $end_date = date('Y-m-d', strtotime('today - 0 days'));
        }
        
        // Start with base query using a subquery approach for filtering
        // This ensures we get the entire POS records even when filtering by product attributes
        $query = Pos::where('pos.created_by', '=', creatorId())
            ->where('pos.workspace', getActiveWorkSpace())
            ->whereBetween('pos_date', [$first_date, $end_date]);
        
        // Apply basic filters
        if (!empty($request->warehouse)) {
            $query->where('pos.warehouse_id', '=', $request->warehouse);
        }
        
        if (!empty($request->customer)) {
            $query->where('pos.customer_id', '=', $request->customer);
        }
        
        // For brand, category, and product filtering, we need a different approach
        if (!empty($request->brand) || !empty($request->category) || !empty($request->product)) {
            // Instead of joining directly, we'll use a subquery to find matching POS IDs
            $posIdsQuery = \DB::table('pos_products')
                ->join('product_services', 'pos_products.product_id', '=', 'product_services.id');
                
            // Apply filters
            if (!empty($request->brand)) {
                $posIdsQuery->where('product_services.brand_id', '=', $request->brand);
            }
            if (!empty($request->category)) {
                $posIdsQuery->where('product_services.category_id', '=', $request->category);
            }
            if (!empty($request->product)) {
                $posIdsQuery->where('pos_products.product_id', '=', $request->product);
            }
            
            $posIds = $posIdsQuery->select('pos_products.pos_id')
                ->distinct()
                ->pluck('pos_id');
                
            $query->whereIn('pos.id', $posIds);
        }
        
        // Get the filtered POS records
        $poses = $query->get();
        
         $return = PosReturn::where('pos_returns.created_by', '=', creatorId())
            ->join('pos_return_payments' , 'pos_returns.id' ,'pos_return_payments.return_id')
            ->where('pos_returns.workspace', getActiveWorkSpace())
            ->whereBetween('return_date', [$first_date, $end_date])
            ->select('pos_returns.return_date', 'pos_return_payments.discount_amount')
            ->get();
       
        $returnposesGrouped = $return->groupBy(function ($val) {
            return Carbon::parse($val->return_date)->format('Y-m-d');
        });
        $returnTotal = [];
        if (!empty($returnposesGrouped) && count($returnposesGrouped) > 0) {
            foreach ($returnposesGrouped as $day => $onepos) {
                $totals = 0;
                foreach ($onepos as $pos) {
                    $totals += $pos->discount_amount;
                }
                $returnTotal[$day] = $totals;
            }
        }
      
        
        // Group by date
        $posesGrouped = $poses->groupBy(function ($val) {
            return Carbon::parse($val->pos_date)->format('Y-m-d');
        });
        
        
        
        // Calculate totals for each day
        $total = [];
        if (!empty($posesGrouped) && count($posesGrouped) > 0) {
            foreach ($posesGrouped as $day => $onepos) {
                $totals = 0;
                foreach ($onepos as $pos) {
                    $totals += $pos->getTotal() + $pos->getTotalTax();
                }
                $total[$day] = $totals;
            }
        }
      
        // Prepare data for chart display
        $arrDuration = [];
        $data = [];
       
        // Generate dates for the chart
        $period = new \DatePeriod(
            new \DateTime($first_date),
            new \DateInterval('P1D'),
            (new \DateTime($end_date))->modify('+1 day')
        );
        
        // Fill in data for each date in the range
        foreach ($period as $date) {
            $current_date = $date->format('Y-m-d');
            $arrDuration[] = $date->format('d-M');
            $data[] = isset($total[$current_date]) ? $total[$current_date] : 0;
            $returnData[] = isset($returnTotal[$current_date]) ? $returnTotal[$current_date] : 0;
        }
       
        // Prepare filter display information
        $filter['startDate'] = $first_date;
        $filter['endDate'] = $end_date;
        
        $warehouses = Warehouse::where('id', '=', $request->warehouse)
            ->where('created_by', creatorId())
            ->first();
        $filter['warehouse'] = !empty($warehouses) ? $warehouses->name : '';
        
        $customers = User::where('type', 'client')
            ->where('id', '=', $request->customer)
            ->where('created_by', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->first();
        $filter['customer'] = !empty($customers) ? $customers->name : '';
        
        $brands = \Workdo\ProductService\Entities\Category::where('id', '=', $request->brand)
            ->where('created_by', creatorId())
            ->first();
        $filter['brand'] = !empty($brands) ? $brands->name : '';
        
        $categories = \Workdo\ProductService\Entities\Category::where('id', '=', $request->category)
            ->where('created_by', creatorId())
            ->first();
        $filter['category'] = !empty($categories) ? $categories->name : '';
        
        // Add product information to filter display
        $productInfo = ProductService::where('id', '=', $request->product)
            ->where('created_by', creatorId())
            ->first();
        $filter['product'] = !empty($productInfo) ? $productInfo->name : '';
       
        return view('pos::report.daily_pos', compact('products', 'brand', 'category', 'warehouse', 'customer', 'arrDuration', 'data', 'filter' , 'returnData'));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}




// public function posDailyReport(Request $request)
// {
//     if(\Auth::user()->isAbleTo('report pos'))
//     {
//         $products = ProductService::where('created_by', '=', creatorId())
//             ->where('workspace_id', getActiveWorkSpace())
//             ->get()
//             ->pluck('name', 'id');
//         $products->prepend('All Product', 0);
        
        
//         $brand = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())
//             ->where('workspace_id', getActiveWorkSpace())
//             ->where('type', 3)
//             ->get()
//             ->pluck('name', 'id');
//         $brand->prepend('All Brand', 0);
        
//         $category = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())
//             ->where('workspace_id', getActiveWorkSpace())
//             ->where('type', 0)
//             ->get()
//             ->pluck('name', 'id');
//         $category->prepend('All Category', 0);
        
//         $warehouse = Warehouse::where('created_by', '=', creatorId())
//             ->where('workspace', getActiveWorkSpace())
//             ->get()
//             ->pluck('name', 'id');
//         $warehouse->prepend('All Warehouse', 0);
        
//         $customer = User::where('type', 'client')
//             ->where('created_by', creatorId())
//             ->where('workspace_id', getActiveWorkSpace())
//             ->get()
//             ->pluck('name', 'id');
//         $customer->prepend('All Customer', 0);
        
//         // Define date range
//         if(!empty($request->start_date) && !empty($request->end_date))
//         {
//             $first_date = $request->start_date;
//             $end_date = $request->end_date;
//         }
//         else
//         {
//             $first_date = date('Y-m-d', strtotime('today - 30 days'));
//             $end_date = date('Y-m-d', strtotime('today - 0 days'));
//         }
        
//         // Start with base query using a subquery approach for filtering
//         // This ensures we get the entire POS records even when filtering by product attributes
//         $query = Pos::where('pos.created_by', '=', creatorId())
//             ->where('pos.workspace', getActiveWorkSpace())
//             ->whereBetween('pos_date', [$first_date, $end_date]);
        
//         // Apply basic filters
//         if (!empty($request->warehouse)) {
//             $query->where('pos.warehouse_id', '=', $request->warehouse);
//         }
        
//         if (!empty($request->customer)) {
//             $query->where('pos.customer_id', '=', $request->customer);
//         }
        
//         // For brand, category, and product filtering, we need a different approach
//         if (!empty($request->brand) || !empty($request->category) || !empty($request->product)) {
//             // Instead of joining directly, we'll use a subquery to find matching POS IDs
//             $posIdsQuery = \DB::table('pos_products')
//                 ->join('product_services', 'pos_products.product_id', '=', 'product_services.id');
                
//             // Apply filters
//             if (!empty($request->brand)) {
//                 $posIdsQuery->where('product_services.brand_id', '=', $request->brand);
//             }
//             if (!empty($request->category)) {
//                 $posIdsQuery->where('product_services.category_id', '=', $request->category);
//             }
//             if (!empty($request->product)) {
//                 $posIdsQuery->where('pos_products.product_id', '=', $request->product);
//             }
            
//             $posIds = $posIdsQuery->select('pos_products.pos_id')
//                 ->distinct()
//                 ->pluck('pos_id');
                
//             $query->whereIn('pos.id', $posIds);
//         }
        
//         // Get the filtered POS records
//         $poses = $query->get();
        
//         // Get return payments for the same date range and apply same filters
//         $returnQuery = \DB::table('pos_return_payments')
//             ->join('pos', 'pos_return_payments.pos_id', '=', 'pos.id')
//             ->where('pos.created_by', '=', creatorId())
//             ->where('pos.workspace', getActiveWorkSpace())
//             ->whereBetween('pos_return_payments.created_at', [$first_date . ' 00:00:00', $end_date . ' 23:59:59']);
        
//         // Apply same filters to return payments
//         if (!empty($request->warehouse)) {
//             $returnQuery->where('pos.warehouse_id', '=', $request->warehouse);
//         }
        
//         if (!empty($request->customer)) {
//             $returnQuery->where('pos.customer_id', '=', $request->customer);
//         }
        
//         // Apply product-related filters to returns as well
//         if (!empty($request->brand) || !empty($request->category) || !empty($request->product)) {
//             $returnQuery->whereIn('pos.id', $posIds);
//         }
        
//         $returnPayments = $returnQuery->select(
//             'pos_return_payments.*',
//             \DB::raw('DATE(pos_return_payments.created_at) as return_date')
//         )->get();
        
//         // Group return payments by date
//         $returnsGrouped = $returnPayments->groupBy('return_date');
        
//         // Group POS records by date
//         $posesGrouped = $poses->groupBy(function ($val) {
//             return Carbon::parse($val->pos_date)->format('Y-m-d');
//         });
        
//         // Calculate totals for each day (POS sales minus returns)
//         $total = [];
//         if (!empty($posesGrouped) && count($posesGrouped) > 0) {
//             foreach ($posesGrouped as $day => $onepos) {
//                 $dailySales = 0;
//                 foreach ($onepos as $pos) {
//                     $dailySales += $pos->getTotal() + $pos->getTotalTax();
//                 }
                
//                 // Subtract return payments for this day
//                 $dailyReturns = 0;
//                 if (isset($returnsGrouped[$day])) {
//                     foreach ($returnsGrouped[$day] as $return) {
//                         $dailyReturns += $return->amount; // Adjust field name as per your table structure
//                     }
//                 }
                
//                 $total[$day] = $dailySales - $dailyReturns;
//             }
//         }
        
//         // Handle days with only returns (no sales)
//         foreach ($returnsGrouped as $day => $dayReturns) {
//             if (!isset($total[$day])) {
//                 $dailyReturns = 0;
//                 foreach ($dayReturns as $return) {
//                     $dailyReturns += $return->amount; // Adjust field name as per your table structure
//                 }
//                 $total[$day] = -$dailyReturns; // Negative value for return-only days
//             }
//         }
        
//         // Prepare data for chart display
//         $arrDuration = [];
//         $data = [];
        
//         // Generate dates for the chart
//         $period = new \DatePeriod(
//             new \DateTime($first_date),
//             new \DateInterval('P1D'),
//             (new \DateTime($end_date))->modify('+1 day')
//         );
        
//         // Fill in data for each date in the range
//         foreach ($period as $date) {
//             $current_date = $date->format('Y-m-d');
//             $arrDuration[] = $date->format('d-M');
//             $data[] = isset($total[$current_date]) ? $total[$current_date] : 0;
//         }
        
//         // Prepare filter display information
//         $filter['startDate'] = $first_date;
//         $filter['endDate'] = $end_date;
        
//         $warehouses = Warehouse::where('id', '=', $request->warehouse)
//             ->where('created_by', creatorId())
//             ->first();
//         $filter['warehouse'] = !empty($warehouses) ? $warehouses->name : '';
        
//         $customers = User::where('type', 'client')
//             ->where('id', '=', $request->customer)
//             ->where('created_by', creatorId())
//             ->where('workspace_id', getActiveWorkSpace())
//             ->first();
//         $filter['customer'] = !empty($customers) ? $customers->name : '';
        
//         $brands = \Workdo\ProductService\Entities\Category::where('id', '=', $request->brand)
//             ->where('created_by', creatorId())
//             ->first();
//         $filter['brand'] = !empty($brands) ? $brands->name : '';
        
//         $categories = \Workdo\ProductService\Entities\Category::where('id', '=', $request->category)
//             ->where('created_by', creatorId())
//             ->first();
//         $filter['category'] = !empty($categories) ? $categories->name : '';
        
//         // Add product information to filter display
//         $productInfo = ProductService::where('id', '=', $request->product)
//             ->where('created_by', creatorId())
//             ->first();
//         $filter['product'] = !empty($productInfo) ? $productInfo->name : '';
        
//         return view('pos::report.daily_pos', compact('products', 'brand', 'category', 'warehouse', 'customer', 'arrDuration', 'data', 'filter'));
//     }
//     else
//     {
//         return redirect()->back()->with('error', __('Permission denied.'));
//     }
// }



public function posMonthlyReport(Request $request)
{
    if(\Auth::user()->isAbleTo('report pos'))
    {
        $monthList = $this->yearMonth();
        $yearList = $this->yearList();
        
        // Add products for filtering
        $products = ProductService::where('created_by', '=', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        $products->prepend('All Product', 0);

        $brand = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->where('type', 3)
            ->get()
            ->pluck('name', 'id');
        $brand->prepend('All Brand', 0);
        
        $category = \Workdo\ProductService\Entities\Category::where('created_by', '=', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->where('type', 0)
            ->get()
            ->pluck('name', 'id');
        $category->prepend('All Category', 0);

        $warehouse = warehouse::where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        $warehouse->prepend('All Warehouse', 0);

        $customer = User::where('type', 'client')
            ->where('created_by', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->get()
            ->pluck('name', 'id');
        $customer->prepend('All Customer', 0);

        // Start with base query
        $query = Pos::where('pos.created_by', '=', creatorId())
            ->where('pos.workspace', getActiveWorkSpace());
            
        // Apply year filter
        if(!empty($request->year))
        {
            $year = $request->year;
        }
        else
        {
            $year = date('Y');
        }
        $query->whereYear('pos_date', $year);

        // Apply basic filters
        if (!empty($request->warehouse))
        {
            $query->where('pos.warehouse_id', '=', $request->warehouse);
        }
        
        if (!empty($request->customer))
        {
            $query->where('pos.customer_id', '=', $request->customer);
        }
        
        // For brand, category, and product filtering, we need a different approach
        if (!empty($request->brand) || !empty($request->category) || !empty($request->product)) {
            // Instead of joining directly, we'll use a subquery to find matching POS IDs
            $posIdsQuery = \DB::table('pos_products')
                ->join('product_services', 'pos_products.product_id', '=', 'product_services.id');
                
            // Apply filters
            if (!empty($request->brand)) {
                $posIdsQuery->where('product_services.brand_id', '=', $request->brand);
            }
            if (!empty($request->category)) {
                $posIdsQuery->where('product_services.category_id', '=', $request->category);
            }
            if (!empty($request->product)) {
                $posIdsQuery->where('pos_products.product_id', '=', $request->product);
            }
            
            $posIds = $posIdsQuery->select('pos_products.pos_id')
                ->distinct()
                ->pluck('pos_id');
                
            $query->whereIn('pos.id', $posIds);
        }

        // Get the filtered POS records
        $poses = $query->get()->groupBy(
            function ($val) {
                return Carbon::parse($val->pos_date)->format('m');
            });
            
        $total = [];
        if (!empty($poses) && count($poses) > 0) {
            foreach ($poses as $month => $onepos) {
                $totals = 0;
                foreach ($onepos as $pos) {
                    $totals += $pos->getTotal() + $pos->getTotalTax();
                }
                $total[$month] = $totals;
            }
        }
        
        $arrDuration = [];
        $data = [];
        for($i = 1; $i <= 12; $i++)
        {
            $dateFormat = date('Y-'.$i.'-01');
            $arrDuration[] = date("my", strtotime($dateFormat));
            $month1 = date("m", strtotime($dateFormat));
            $data[] = isset($total[$month1]) ? $total[$month1] : 0;
        }

        // Prepare filter display information
        $filter['startMonth'] = 'Jan-' . $year;
        $filter['endMonth']   = 'Dec-' . $year;
        
        $warehouses = warehouse::where('id', '=', $request->warehouse)
            ->where('created_by', creatorId())
            ->first();
        $filter['warehouse'] = !empty($warehouses) ? $warehouses->name : '';
        
        $customers = User::where('type', 'client')
            ->where('id', '=', $request->customer)
            ->where('created_by', creatorId())
            ->where('workspace_id', getActiveWorkSpace())
            ->first();
        $filter['customer'] = !empty($customers) ? $customers->name : '';
        
        $brands = \Workdo\ProductService\Entities\Category::where('id', '=', $request->brand)
            ->where('created_by', creatorId())
            ->first();
        $filter['brand'] = !empty($brands) ? $brands->name : '';
        
        $categories = \Workdo\ProductService\Entities\Category::where('id', '=', $request->category)
            ->where('created_by', creatorId())
            ->first();
        $filter['category'] = !empty($categories) ? $categories->name : '';
        
        // Add product information to filter display
        $productInfo = ProductService::where('id', '=', $request->product)
            ->where('created_by', creatorId())
            ->first();
        $filter['product'] = !empty($productInfo) ? $productInfo->name : '';

        return view('pos::report.monthly_pos', compact('products', 'brand', 'category', 'monthList', 'yearList', 'warehouse', 'customer', 'arrDuration', 'data', 'filter'));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}






   
//     public function posVsPurchaseReport(Request $request)
//     {
//         if(\Auth::user()->isAbleTo('report pos'))
//         {
//             $data['monthList'] = $month = $this->yearMonth();
//             $data['yearList']  = $this->yearList();

//             if(isset($request->year))
//             {
//                 $year = $request->year;
//             }
//             else
//             {
//                 $year = date('Y');
//             }
//             $data['currentYear'] = $year;


//             // ------------------------------TOTAL POS-----------------------------------------------------------

//             $posData = Pos:: selectRaw('MONTH(pos_date) as month,YEAR(pos_date) as year,pos_id,id')
//                 ->where('created_by', creatorId());
//             $posData->whereRAW('YEAR(pos_date) =?', [$year]);

//             $posData        = $posData->get();
//             $posTotalArray = [];
//             foreach($posData as $pos)
//             {
//                 $posTotalArray[$pos->month] = 0;
//             }
//             foreach($posData as $pos)
//             {
//                 $posTotalArray[$pos->month] += $pos->getTotal() + $pos->getTotalTax();
//             }


//             // ------------------------------ TOTAL PAYMENT-----------------------------------------------------------
//             $purchaseData = Purchase:: selectRaw('MONTH(send_date) as month,YEAR(send_date) as year,purchase_id,id')
//                 ->where('created_by', creatorId())
//                 ->where('status', '!=', 0);
//             $purchaseData->whereRAW('YEAR(send_date) =?', [$year]);
//             $purchaseData        = $purchaseData->get();
//             $purchaseTotalArray = [];
//             foreach($purchaseData as $purchase)
//             {
//                 $purchaseTotalArray[$purchase->month] = 0;
//             }
//             foreach($purchaseData as $purchase)
//             {
//                 $purchaseTotalArray[$purchase->month] += $purchase->getTotal();
//             }

// //            -----------------------------

//             for($i = 1; $i <= 12; $i++)
//             {
//                 $PosTotal[] = array_key_exists($i, $posTotalArray) ? $posTotalArray[$i] : 0;
//                 $PurchaseTotal[] = array_key_exists($i, $purchaseTotalArray) ? $purchaseTotalArray[$i] : 0;

//             }
//             $totalPos = array_map(
//                 function (){
//                     return array_sum(func_get_args());
//                 }, $PosTotal
//             );

//             $totalPurchase = array_map(
//                 function (){
//                     return array_sum(func_get_args());
//                 }, $PurchaseTotal
//             );


//             $profits = [];
//             $keys   = array_keys($totalPos + $totalPurchase);
//             foreach($keys as $v)
//             {
//                 $profits[$v] = number_format((empty($totalPos[$v]) ? 0 : $totalPos[$v]) - (empty($totalPurchase[$v]) ? 0 : $totalPurchase[$v]), 2);
//             }

//             $data['posTotal']        = $PosTotal;
//             $data['purchaseTotal']        = $PurchaseTotal;
//             $data['profits']              = $profits;
//             $filter['startDateRange'] = 'Jan-' . $year;
//             $filter['endDateRange']   = 'Dec-' . $year;


//             return view('pos::report.pos_vs_purchase', compact('filter'),  $data);
//         }
//         else
//         {
//             return redirect()->back()->with('error', __('Permission denied.'));
//         }
//     }


public function posVsPurchaseReport(Request $request)
{
    if(\Auth::user()->isAbleTo('report pos'))
    {
        $data['monthList'] = $month = $this->yearMonth();
        $data['yearList']  = $this->yearList();
        if(isset($request->year))
        {
            $year = $request->year;
        }
        else
        {
            $year = date('Y');
        }
        $data['currentYear'] = $year;

        // ------------------------------TOTAL POS-----------------------------------------------------------
        $posData = Pos::selectRaw('MONTH(pos_date) as month, YEAR(pos_date) as year, pos_id, id')
            ->where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace());
        $posData->whereRAW('YEAR(pos_date) =?', [$year]);
        $posData = $posData->get();
        
        $posTotalArray = [];
        foreach($posData as $pos)
        {
            $posTotalArray[$pos->month] = 0;
        }
        foreach($posData as $pos)
        {
            $posTotalArray[$pos->month] += $pos->getTotal() + $pos->getTotalTax();
        }
        
        // ------------------------------POS RETURNS-----------------------------------------------------------
        $posReturnData = PosReturnPayment::selectRaw('MONTH(date) as month, YEAR(date) as year, id, amount')
            ->where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace());
        $posReturnData->whereRAW('YEAR(date) =?', [$year]);
        $posReturnData = $posReturnData->get();
        
        $posReturnTotalArray = [];
        foreach($posReturnData as $posReturn)
        {
            $posReturnTotalArray[$posReturn->month] = 0;
        }
        foreach($posReturnData as $posReturn)
        {
            $posReturnTotalArray[$posReturn->month] += $posReturn->amount;
        }
       
        // ------------------------------ TOTAL PURCHASE-----------------------------------------------------------
        $purchaseData = Purchase::selectRaw('MONTH(send_date) as month, YEAR(send_date) as year, purchase_id, id')
            ->where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->where('status', '!=', 0);
        $purchaseData->whereRAW('YEAR(send_date) =?', [$year]);
        $purchaseData = $purchaseData->get();
      
        $purchaseTotalArray = [];
        foreach($purchaseData as $purchase)
        {
            $purchaseTotalArray[$purchase->month] = 0;
        }
        foreach($purchaseData as $purchase)
        {
            $purchaseTotalArray[$purchase->month] += $purchase->getTotal();
        }
        //  $purchaseTotalArray
        // ------------------------------PURCHASE RETURNS-----------------------------------------------------------
        $purchaseReturnData = PurchaseReturn::selectRaw('MONTH(return_date) as month, YEAR(return_date) as year, id, final_amount')
            ->where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace());
        $purchaseReturnData->whereRAW('YEAR(return_date) =?', [$year]);
        $purchaseReturnData = $purchaseReturnData->get();
        //  return $purchaseReturnData ;
        $purchaseReturnTotalArray = [];
        foreach($purchaseReturnData as $purchaseReturn)
        {
            $purchaseReturnTotalArray[$purchaseReturn->month] = 0;
        }
        foreach($purchaseReturnData as $purchaseReturn)
        {
            $purchaseReturnTotalArray[$purchaseReturn->month] += $purchaseReturn->final_amount;
        }
        //  return $purchaseReturnData ;
        // -----------------------------MONTHLY CALCULATIONS------------------------------
        for($i = 1; $i <= 12; $i++)
        {
            // Calculate net POS (sales minus returns)
            $posAmount = array_key_exists($i, $posTotalArray) ? $posTotalArray[$i] : 0;
            $posReturnAmount = array_key_exists($i, $posReturnTotalArray) ? $posReturnTotalArray[$i] : 0;
            $PosTotal[] = $posAmount - $posReturnAmount;
            
            // Calculate net Purchase (purchases minus returns)
            $purchaseAmount = array_key_exists($i, $purchaseTotalArray) ? $purchaseTotalArray[$i] : 0;
            $purchaseReturnAmount = array_key_exists($i, $purchaseReturnTotalArray) ? $purchaseReturnTotalArray[$i] : 0;
            $PurchaseTotal[] = $purchaseAmount - $purchaseReturnAmount;
        }
        
        $totalPos = array_map(
            function (){
                return array_sum(func_get_args());
            }, $PosTotal
        );
        
        $totalPurchase = array_map(
            function (){
                return array_sum(func_get_args());
            }, $PurchaseTotal
        );
        
        $profits = [];
        $keys = array_keys($totalPos + $totalPurchase);
        foreach($keys as $v)
        {
            $profits[$v] = number_format((empty($totalPos[$v]) ? 0 : $totalPos[$v]) - (empty($totalPurchase[$v]) ? 0 : $totalPurchase[$v]), 2);
        }
        
        // Add all calculated data to the view
        $data['posTotal'] = $PosTotal;
        $data['purchaseTotal'] = $PurchaseTotal;
        $data['profits'] = $profits;
        
        // Additional data for the view to show returns
        $data['posReturnTotal'] = array_map(function($i) use ($posReturnTotalArray) {
            return array_key_exists($i, $posReturnTotalArray) ? $posReturnTotalArray[$i] : 0;
        }, range(1, 12));
        
        $data['purchaseReturnTotal'] = array_map(function($i) use ($purchaseReturnTotalArray) {
            return array_key_exists($i, $purchaseReturnTotalArray) ? $purchaseReturnTotalArray[$i] : 0;
        }, range(1, 12));
        
        $filter['startDateRange'] = 'Jan-' . $year;
        $filter['endDateRange'] = 'Dec-' . $year;
        
        return view('pos::report.pos_vs_purchase', compact('filter'), $data);
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}




}
