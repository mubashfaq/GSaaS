<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\AddOn;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use App\Facades\ModuleFacade as Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;
use SendGrid\Mail\Mail;
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if(Auth::check())
        {
            return redirect('dashboard');
        }
        else
        {
            if(!file_exists(storage_path() . "/installed"))
            {
                header('location:install');
                die;
            }
            else
            {
                $migrationPath = '/database/migrations/2024_07_17_120445_add_image_to_add_ons_table.php';
                Artisan::call('migrate', [
                    '--path' => $migrationPath,
                ]);
                if(admin_setting('landing_page') == 'on')
                {
                    if(module_is_active('LandingPage'))
                    {
                        return view('landingpage::layouts.landingpage');
                    }
                    else
                    {
                        return view('marketplace.landing');
                    }
                }
                else
                {
                    return redirect('login');
                }
            }
        }
    }

    public function Dashboard()
    {
        if(Auth::check())
        {
            if(Auth::user()->type == 'super admin')
            {
                // Update wizard
                $ranMigrations = DB::table('migrations')->pluck('migration');
                $modules = Module::allModules();

                $migrationFiles = collect(File::glob(database_path('migrations/*.php')))
                ->map(function ($path) {
                    return File::name($path);
                });
                foreach ($modules as $key => $module) {
                    // Get the module directorie in your project
                    $directory = "packages/workdo/".$module->name."/src/Database/Migrations";

                    $files = collect(File::glob("{$directory}/*.php"))
                        ->map(function ($path) {
                            return File::name($path);
                        });
                    $migrationFiles = $migrationFiles->merge($files);
                }
                // Calculate the pending migrations by diffing the two lists
                $pendingMigrations = $migrationFiles->diff($ranMigrations);
                if(count($pendingMigrations) > 0)
                {
                    return redirect()->route('LaravelUpdater::welcome');
                }


                $user                       = Auth::user();
                $user['total_user']         = $user->countCompany();
                $user['total_paid_user']    = $user->countPaidCompany();
                $user['total_orders']       = Order::total_orders();
                $user['total_orders_price'] = Order::total_orders_price();
                $chartData                  = $this->getOrderChart(['duration' => 'week']);
                // $user['total_plans'] = Plan::all()->count();
                 $user['total_plans'] = Plan::where('custom_plan',0)->get()->count();
                $popular_plan = DB::table('orders')
                ->select('orders.plan_id', 'plans.*', DB::raw('count(*) as count'))
                ->join('plans', 'orders.plan_id', '=', 'plans.id')
                ->groupBy('orders.plan_id')
                ->orderByDesc('count')
                ->first();

                $user['popular_plan'] = $popular_plan;

                return view('dashboard.dashboard', compact('user', 'chartData'));
            }
            else
            {
                $user = auth()->user();

                $menu = new \App\Classes\Menu($user);
                event(new \App\Events\CompanyMenuEvent($menu));
                $menu_items = $menu->menu;
                $dashboardItem = collect($menu_items)->first(function ($item) {
                    return $item['parent'] === 'dashboard';
                });

                if ($dashboardItem) {
                    $route = isset($dashboardItem['route']) ? $dashboardItem['route'] : null;
                    if($route)
                    {
                        return redirect()->route($route);
                    }
                }
                return view('dashboard');
            }
        }
        else
        {
            return redirect()->route('start');
        }
    }

    public function getOrderChart($arrParam)
    {
        $arrDuration = [];
        if($arrParam['duration'])
        {
            if($arrParam['duration'] == 'week')
            {
                $previous_week = strtotime("-2 week +1 day");
                for($i = 0; $i < 14; $i++)
                {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week                              = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }
        // $arrTask          = [];
        // $arrTask['label'] = [];
        // $arrTask['data']  = [];
        // foreach($arrDuration as $date => $label)
        // {
        //     $data               = Order::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
        //     $arrTask['label'][] = $label;
        //     $arrTask['data'][]  = $data->total;
        // }
        // return $arrTask;

        // Create an array of dates from your $arrDuration array
        $dates = array_keys($arrDuration);

        $orders = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->whereIn(DB::raw('DATE(created_at)'), $dates)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();
        // Initialize an empty $arrTask array
        $arrTask = ['label' => [], 'data' => []];

        foreach ($dates as $date) {
            $label = $arrDuration[$date];
            $total = 0;

            foreach ($orders as $item) {
                if ($item->date == $date) {
                    $total = $item->total;
                    break;
                }
            }

            $arrTask['label'][] = $label;
            $arrTask['data'][] = $total;
        }
        return $arrTask;
    }
    public function SoftwareDetails($slug)
    {
        $modules_all = Module::all();
        $modules = [];
        if(count($modules_all) > 0)
        {

            $modules = array_intersect_key(
                $modules_all,  // the array with all keys
                array_flip(array_rand($modules_all,(count($modules_all) <  6) ? count($modules_all) : 6 )) // keys to be extracted
            );

        }
        $plan = Plan::first();
        $addon = AddOn::where('name',$slug)->first();
        if(!empty($addon) && !empty($addon->module))
        {
            $module = Module::find($addon->module);
            if(!empty($module))
            {
                try {
                    if(module_is_active('LandingPage'))
                    {
                        return view('landingpage::marketplace.index',compact('modules','module','plan'));
                    }
                    else{
                        return view($module->package_name.'::marketplace.index',compact('modules','module','plan'));
                    }
                } catch (\Throwable $th) {

                }
            }
        }

        if (module_is_active('LandingPage')) {
            $layout = 'landingpage::layouts.marketplace';
        } else {
            $layout = 'marketplace.marketplace';
        }

        return view('marketplace.detail_not_found',compact('modules','layout'));

    }

    public function Software(Request $request)
    {
        // Get the query parameter from the request
        $query = $request->query('query');
        // Get all modules (assuming Module::all() returns all modules)
        $modules = Module::all();

        // Filter modules based on the query parameter
        if ($query) {
            $modules = array_filter($modules, function ($module) use ($query) {
                // You may need to adjust this condition based on your requirements
                return stripos($module->name, $query) !== false;
            });
        }
        // Rest of your code
        if (module_is_active('LandingPage')) {
            $layout = 'landingpage::layouts.marketplace';
        } else {
            $layout = 'marketplace.marketplace';
        }

        return view('marketplace.software', compact('modules', 'layout'));
    }

    public function Pricing()
    {
        $admin_settings = getAdminAllSetting();
        if(module_is_active('GoogleCaptcha') && (isset($admin_settings['google_recaptcha_is_on']) ? $admin_settings['google_recaptcha_is_on'] : 'off') == 'on' )
        {
            config(['captcha.secret' => isset($admin_settings['google_recaptcha_secret']) ? $admin_settings['google_recaptcha_secret'] : '']);
            config(['captcha.sitekey' => isset($admin_settings['google_recaptcha_key']) ? $admin_settings['google_recaptcha_key'] : '']);
        }
        if(Auth::check())
        {
            if(Auth::user()->type == 'company')
            {
                return redirect('plans');
            }
            else
            {
                return redirect('dashboard');
            }
        }
        else
        {
            $plan = Plan::first();
            $modules = Module::all();

            if (module_is_active('LandingPage')) {
                $layout = 'landingpage::layouts.marketplace';
                return view('landingpage::layouts.pricing',compact('modules','plan','layout'));

            } else {
                $layout = 'marketplace.marketplace';
            }

            return view('marketplace.pricing',compact('modules','plan','layout'));
        }
    }

    public function PricingPlans()
    {
        $plan = Plan::where('custom_plan', 0)->get();
        $modules = Module::all();

        if (module_is_active('LandingPage')) {
            $layout = 'landingpage::layouts.marketplace';
            return view('landingpage::layouts.pricing-plans',compact('modules','plan','layout'));

        } else {
            $layout = 'marketplace.marketplace';
        }

        return view('marketplace.pricing',compact('modules','plan','layout'));
    }



    public function CustomPage(Request $request)
    {
        $modules = Module::all();

        if (module_is_active('LandingPage')) {
            $layout = 'landingpage::layouts.marketplace';
        } else {
            $layout = 'marketplace.marketplace';
        }
        if($request['page'] == 'terms_and_conditions' || $request['page'] == 'privacy_policy')
        {
            return view('custompage.'.$request['page'],compact('modules','layout'));
        }
        else
        {
            return view('marketplace.detail_not_found',compact('modules','layout'));
        }

    }
    
    // public function subscribe(Request $request)
    // {
    //   try {
    //         // Validate the request
    //         $validator = Validator::make($request->all(), [
    //             'email' => 'required|email|max:255'
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Validation failed',
    //                 'errors' => $validator->errors()
    //             ], 422);
    //         }

    //         $email = strtolower(trim($request->email));

    //         // Check if email already exists
    //         $existingSubscriber = DB::table('newsletter_subscribers')
    //             ->where('email', $email)
    //             ->first();

    //         if ($existingSubscriber) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Email already exists'
    //             ], 409);
    //         }

    //         // Insert the new subscriber
    //         DB::table('newsletter_subscribers')->insert([
    //             'email' => $email,
    //             'subscribed_at' => now(),
    //             'ip_address' => $request->ip(),
    //             'user_agent' => $request->userAgent(),
    //             'is_active' => true,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         // Log successful subscription
    //         Log::info('New newsletter subscription', [
    //             'email' => $email,
    //             'ip' => $request->ip()
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Successfully subscribed to newsletter!'
    //         ], 200);

    //     } catch (Exception $e) {
    //         // Log the error
    //         Log::error('Newsletter subscription error: ' . $e->getMessage(), [
    //             'email' => $request->email ?? 'unknown',
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred while processing your subscription. Please try again later.'
    //         ], 500);
    //     }
    // }
    
    public function subscribe(Request $request)
{
    try {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = strtolower(trim($request->email));

        // Check if email already exists
        $existingSubscriber = DB::table('newsletter_subscribers')
            ->where('email', $email)
            ->first();

        if ($existingSubscriber) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists'
            ], 409);
        }

        // Insert the new subscriber
        DB::table('newsletter_subscribers')->insert([
            'email' => $email,
            'subscribed_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Send confirmation email using SendGrid
        $renderedView = view('email.newsletter_subscription_mail', [
            'name' => 'Subscriber', // or use $request->name if available
        ])->render();

        $emailToSend = new \SendGrid\Mail\Mail();
        $emailToSend->setFrom("support@gsaas.com.au", "Gsaas");
        $emailToSend->setSubject("Thank you for subscribing to our newsletter!");
        $emailToSend->addTo($email);
        $emailToSend->addContent("text/html", $renderedView);

        $sendgrid = new \SendGrid("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");

        try {
            $response = $sendgrid->send($emailToSend);
        } catch (Exception $e) {
            Log::error('Failed to send subscription confirmation email: ' . $e->getMessage());
        }

        // Log successful subscription
        Log::info('New newsletter subscription', [
            'email' => $email,
            'ip' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to newsletter!'
        ], 200);

    } catch (Exception $e) {
        // Log the error
        Log::error('Newsletter subscription error: ' . $e->getMessage(), [
            'email' => $request->email ?? 'unknown',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while processing your subscription. Please try again later.'
        ], 500);
    }
}



// public function contact(Request $request)
// {
   
//     try {
//         // Validate input
//         $validator = Validator::make($request->all(), [
//             'name'    => 'required|string|max:255',
//             'email'   => 'required|email|max:255',
//             'phone'   => 'nullable|string|max:20',
//             'message' => 'required|string|max:2000',
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Validation failed',
//                 'errors' => $validator->errors(),
//             ], 422);
//         }

//         // Save message
//         DB::table('contact_us_messages')->insert([
//             'name'       => trim($request->name),
//             'email'      => strtolower(trim($request->email)),
//             'phone'      => $request->phone,
//             'message'    => $request->message,
//             'ip_address' => $request->ip(),
//             'user_agent' => $request->userAgent(),
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         // Send email notification
//         $renderedView = view('email.contact_us_mail', [
//             'name'    => $request->name,
//             'email'   => $request->email,
//             'phone'   => $request->phone,
//             'message' => $request->message,
//         ])->render();
//         $email = strtolower(trim($request->email));
//         $emailToSend = new \SendGrid\Mail\Mail();
//         $emailToSend->setFrom("support@gsaas.com.au", "Gsaas");
//         $emailToSend->setSubject("New Contact Us Message");
//       $emailToSend->addTo($email); // Admin email
//         $emailToSend->addContent("text/html", $renderedView);

//         $sendgrid = new \SendGrid("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");
//         try {
//             $sendgrid->send($emailToSend);
//         } catch (Exception $e) {
//             Log::error('Contact email failed: ' . $e->getMessage());
//         }

//         return response()->json([
//             'success' => true,
//             'message' => 'Your message has been sent successfully!'
//         ], 200);

//     } catch (\Exception $e) {
//         Log::error('Contact Us Error: ' . $e->getMessage());

//         return response()->json([
//             'success' => false,
//             'message' => 'Something went wrong, please try again later.'
//         ], 500);
//     }
// }

public function contact(Request $request)
{
   
    try {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        // Save message to database
        DB::table('contact_us_messages')->insert([
            'name'       => trim($request->name),
            'email'      => strtolower(trim($request->email)),
            'phone'      => $request->phone,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Send thank you email to customer
        $customerEmail = strtolower(trim($request->email));
        
        // Render the thank you email template
        $renderedView = view('email.contact_us_mail', [
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'message' => $request->message,
        ])->render();
        
        // Create SendGrid email
        $emailToSend = new \SendGrid\Mail\Mail();
        $emailToSend->setFrom("support@gsaas.com.au", "GSaaS Support Team");
        $emailToSend->setSubject("Thank you for contacting us - We've received your message");
        $emailToSend->addTo($customerEmail, $request->name); // Send to customer
        $emailToSend->addContent("text/html", $renderedView);
        
        // Add reply-to for better email handling
        $emailToSend->setReplyTo("support@gsaas.com.au", "GSaaS Support");
        
        // Use environment variable for API key (more secure)
         $sendgrid = new \SendGrid("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");
        // $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        
        try {
            $response = $sendgrid->send($emailToSend);
            
            // Log success with status code
            Log::info('Thank you email sent successfully', [
                'customer_email' => $customerEmail,
                'status_code' => $response->statusCode(),
                'customer_name' => $request->name
            ]);
            
            // Check if email was accepted
            if ($response->statusCode() >= 200 && $response->statusCode() < 300) {
                Log::info('Email accepted by SendGrid', ['status' => $response->statusCode()]);
            } else {
                Log::warning('Unexpected SendGrid response', [
                    'status' => $response->statusCode(),
                    'body' => $response->body()
                ]);
            }
            
        } catch (Exception $e) {
            Log::error('SendGrid email failed', [
                'error' => $e->getMessage(),
                'customer_email' => $customerEmail,
                'customer_name' => $request->name
            ]);
            
            // You might want to continue even if email fails
            // so the user still gets a success response
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully! We will get back to you soon.'
        ], 200);
        
    } catch (\Exception $e) {
        Log::error('Contact Us Error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong, please try again later.'
        ], 500);
    }
}


public function becomeReseller(Request $request)
{
    try {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:reseller_applications,email',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'required|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'company_size' => 'required|in:1-10,11-50,51-200,201-500,500+',
            'industry' => 'required|string|max:255',
            'experience_level' => 'required|in:Beginner,Intermediate,Advanced,Expert',
            'why_reseller' => 'required|string|max:2000',
            'target_market' => 'nullable|string|max:1000',
            'expected_monthly_sales' => 'nullable|numeric|min:0|max:999999.99',
            'has_sales_team' => 'boolean',
            'team_size' => 'nullable|integer|min:0|max:10000',
            'additional_info' => 'nullable|string|max:2000',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        // Save reseller application to database
        $applicationData = [
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'phone' => $request->phone,
            'company_name' => trim($request->company_name),
            'company_website' => $request->company_website,
            'company_size' => $request->company_size,
            'industry' => $request->industry,
            'experience_level' => $request->experience_level,
            'why_reseller' => $request->why_reseller,
            'target_market' => $request->target_market,
            'expected_monthly_sales' => $request->expected_monthly_sales,
            'has_sales_team' => $request->has_sales_team ?? false,
            'team_size' => $request->team_size,
            'additional_info' => $request->additional_info,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('reseller_applications')->insert($applicationData);
        

        
        // Use SendGrid API
        $sendgrid = new \SendGrid("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");
        
        try {
            // Send confirmation email to applicant only
            $confirmationView = view('email.reseller_application_confirmation', [
                'name' => $request->name,
                'email' => $request->email,
                'company_name' => $request->company_name,
            ])->render();
            
            $applicantEmail = new \SendGrid\Mail\Mail();
            $applicantEmail->setFrom("partnerships@gsaas.com.au", "GSaaS Partnership Team");
            $applicantEmail->setSubject("Thank you for your reseller application - Application received");
            $applicantEmail->addTo(strtolower(trim($request->email)), $request->name);
            $applicantEmail->addContent("text/html", $confirmationView);
            $applicantEmail->setReplyTo("partnerships@gsaas.com.au", "GSaaS Partnerships");
            
            $response = $sendgrid->send($applicantEmail);
            Log::info('Reseller application confirmation email sent', [
                'applicant_email' => $request->email,
                'status_code' => $response->statusCode(),
                'company_name' => $request->company_name
            ]);
            
        } catch (Exception $e) {
            Log::error('Reseller application email failed', [
                'error' => $e->getMessage(),
                'applicant_email' => $request->email,
                'company_name' => $request->company_name,
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Your reseller application has been submitted successfully! We will review your application and get back to you within 2-3 business days.'
        ], 200);
        
    } catch (\Exception $e) {
        Log::error('Reseller Application Error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong, please try again later.'
        ], 500);
    }
}

        
    

}
