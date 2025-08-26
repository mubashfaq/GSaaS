<?php

namespace Workdo\Bookings\Entities;

use App\Models\User;
use App\Models\WorkSpace;
use Carbon\Carbon;
use Workdo\Bookings\Entities\BookingsPackage;
use Workdo\Bookings\Entities\BookingsCustomer;
use Workdo\ProductService\Entities\ProductService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingsAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'appointment_id',
        'date',
        'service',
        'package',
        'staff',
        'client_id',
        'start_time',
        'end_time',
        'your_country',
        'your_state',
        'your_city',
        'your_address',
        'your_zip_code',
        'our_country',
        'our_state',
        'our_city',
        'our_zip_code',
        'payment',
        'stage_id',
        'created_by',
        'workspace',
    ];

    public static $status = [
        'Pending' ,
        'Scheduled',
        'Confirmed',
        'Cancelled',
        'Completed',
    ];

    public static function appointmentNumberFormat($number,$company_id = null,$workspace = null)
    {
        if(!empty($company_id) && empty($workspace))
        {
            $company_settings = getCompanyAllSetting($company_id);
        }
        elseif(!empty($company_id) && !empty($workspace))
        {
            $company_settings = getCompanyAllSetting($company_id,$workspace);
        }
        else
        {
            $company_settings = getCompanyAllSetting();
        }

        $data = '#APP0000';
        return $data . sprintf("%01d", $number);
    }

    public function customerData()
    {
        return $this->hasOne(BookingsCustomer::class, 'id', 'client_id')->with('client');
    }

    public function appointment_staff()
    {
        return $this->hasOne(User::class, 'id', 'staff');
    }

    public function appointment_service()
    {
        return $this->hasOne(ProductService::class, 'id', 'service');
    }

    public function appointment_package()
    {
        return $this->hasOne(BookingsPackage::class, 'id', 'package');
    }
    
    
    
public static function timeSlot($service = null, $date = null, $appointment = null)
{
    $services = BookingsPackage::find($service);
    if (empty($services)) {
        return [];
    }
    
    $company_settings = getCompanyAllSetting($services->created_by, $services->workspace);
    $maximum_slot = isset($company_settings['maximum_slot']) ? $company_settings['maximum_slot'] : '1';
    
    if ($date) {
        $selectedDate = Carbon::createFromFormat('Y-m-d', $date);
        $dayName = $selectedDate->format('l');

        $businessday = BookingsBusinessHours::where('created_by', $services->created_by)
            ->where('workspace_id', $services->workspace)
            ->where('day_name', $dayName)
            ->first();
            
        // Check if business day exists and is not marked as day off
        if (empty($businessday) || $businessday->day_off === 'on') {
            return [];
        }

        // Parse duration - this needs to handle "HH:MM" format as minutes
        $durationes = $services->delivery_time;
        // Check if duration is in "HH:MM" format
        if (strpos($durationes, ':') !== false) {
            $parts = explode(':', $durationes);
            $duration = (intval($parts[0]) * 60) + intval($parts[1]);
        } else {
            $duration = BookingsAppointment::convertToMinutes($durationes);
        }
        
        // Use a reasonable minimum duration if calculated value is too large
        if ($duration > 720) { // If more than 12 hours, use 60 minutes as default
            $duration = 60;
        }

        $start_time = Carbon::createFromFormat('H:i:s', $businessday->start_time);
        $end_time = Carbon::createFromFormat('H:i:s', $businessday->end_time);

        // Parse break times correctly
        $break_times_string = $businessday->break_hours;
        // Remove extra quotes if present
        if (substr($break_times_string, 0, 1) === '"' && substr($break_times_string, -1) === '"') {
            $break_times_string = substr($break_times_string, 1, -1);
        }
        
        $break_times = !empty($break_times_string) ? json_decode($break_times_string, true) : [];
        if (json_last_error() !== JSON_ERROR_NONE) {
            $break_times = []; // Reset to empty array if JSON decode failed
        }
        
        $timeSlots = [];
        $currentTime = clone $start_time;
        
        // Generate all possible time slots for the day
        while (true) {
            $slotStart = clone $currentTime;
            $slotEnd = (clone $slotStart)->addMinutes($duration);
            
            // If slot end time exceeds business end time, we're done
            if ($slotEnd->gt($end_time)) {
                break;
            }
            
            $slot = [
                'start' => $slotStart->format('H:i'),
                'end' => $slotEnd->format('H:i'),
                'available' => true
            ];
            
            // Check if slot overlaps with any break
            $overlapsBreak = false;
            if (is_array($break_times) && !empty($break_times)) {
                foreach ($break_times as $break) {
                    if (isset($break['start']) && isset($break['end'])) {
                        $breakStart = Carbon::createFromFormat('H:i', $break['start']);
                        $breakEnd = Carbon::createFromFormat('H:i', $break['end']);
                        
                        // Check if slot overlaps with this break time
                        if (
                            ($slotStart->gte($breakStart) && $slotStart->lt($breakEnd)) ||
                            ($slotEnd->gt($breakStart) && $slotEnd->lte($breakEnd)) ||
                            ($slotStart->lt($breakStart) && $slotEnd->gt($breakEnd))
                        ) {
                            $overlapsBreak = true;
                            break;
                        }
                    }
                }
            }
            
            if (!$overlapsBreak) {
                // Check if this is the current appointment being edited
                if (!empty($appointment) && 
                    $appointment->start_time == $slot['start'] && 
                    $appointment->end_time == $slot['end']) {
                    // This is the current appointment, keep it available
                } else {
                    // Check if slot is already booked
                    try {
                        $bookedCount = BookingsAppointment::isSlotBooked(
                            $slot, 
                            $service, 
                            $date, 
                            $services->workspace
                        );
                        
                        if ($bookedCount >= $maximum_slot) {
                            $slot['available'] = false;
                        }
                    } catch (\Exception $e) {
                        // In case of error, keep the slot available
                    }
                }
                
                $timeSlots[] = $slot;
            }
            
            $currentTime = $slotEnd;
        }
        
        return $timeSlots;
    }
    
    return [];
}






    // public static function timeSlot($service = null, $date = null, $appointment=null)
    // {
    //     $services = BookingsPackage::find($service);
    //     $company_settings = getCompanyAllSetting($services->created_by, $services->workspace);
    //     $maximum_slot = isset($company_settings['maximum_slot']) ? $company_settings['maximum_slot'] : '1';
        
    //     if($date && !empty($services))
    //     {
    //         $selectedDate = Carbon::createFromFormat('Y-m-d', $date);
    //         $dayName = $selectedDate->format('l');

    //         $businessday = BookingsBusinessHours::where('created_by',$services->created_by)->where('workspace_id',$services->workspace)->where('day_name',$dayName)->first();

    //         $durationes = $services->delivery_time;

    //         $duration = BookingsAppointment::convertToMinutes($durationes);

    //         $start_time = Carbon::createFromFormat('H:i:s', isset($businessday->start_time) ? $businessday->start_time : '09:30:00');

    //         $end_time = Carbon::createFromFormat('H:i:s', isset($businessday->end_time) ? $businessday->end_time : '18:00:00');

    //         $break_times = isset($businessday->break_hours) ? json_decode($businessday->break_hours, true) : '';
            
    //         $timeSlots = [];
    //         $currentSlot = clone $start_time;

    //         if (is_array($break_times)) {
    //             foreach ($break_times as $break) {
    //                 $breakStart = Carbon::createFromFormat('H:i', $break['start']);
    //                 $breakEnd = Carbon::createFromFormat('H:i', $break['end']);
    //                 // Add time slots before the break, excluding booked slots
    //                 while ($currentSlot->addMinutes($duration)->lt($breakStart)) {

    //                     $slot = [
    //                         'start' => $currentSlot->copy()->subMinutes($duration)->format('H:i'),
    //                         'end' => $currentSlot->format('H:i'),
    //                         'available' => false
    //                     ];

    //                     if(!empty($appointment)){
    //                         if($appointment->start_time == $slot['start']  && $appointment->end_time == $slot['end']){
    //                             $slot = [
    //                                 'start' => $currentSlot->copy()->subMinutes($duration)->format('H:i'),
    //                                 'end' => $currentSlot->format('H:i'),
    //                                 'available' => true
    //                             ];
    //                         }
    //                     }

    //                     $bookedCount = BookingsAppointment::isSlotBooked($slot, $booked_appointment);

    //                     if ($bookedCount < $maximum_slot) {
    //                         $timeSlots[] = $slot;
    //                     }
    //                 }

    //                 // Skip time slots during the break
    //                 if ($currentSlot->lte($breakEnd)) {
    //                     $currentSlot = $breakEnd->copy();
    //                 }
    //             }
    //         }

    //         $data = [];
    //         // Add remaining time slots after the last break, excluding booked slots
    //         while ($currentSlot->addMinutes($duration)->lte($end_time)) {
    //             $slot = [
    //                 'start' => $currentSlot->copy()->subMinutes($duration)->format('H:i'),
    //                 'end' => $currentSlot->format('H:i'),
    //                 'available' => false
    //             ];
    //             $data[] = $slot;

    //             if(!empty($appointment)){

    //                 if($appointment->start_time == $slot['start']  && $appointment->end_time == $slot['end']){
    //                     $slot = [
    //                         'start' => $currentSlot->copy()->subMinutes($duration)->format('H:i'),
    //                         'end' => $currentSlot->format('H:i'),
    //                         'available' => true

    //                     ];
    //                 }
    //             }

    //             $bookedCount = BookingsAppointment::isSlotBooked($slot, $service, $date, $services->workspace);
    //             if ($bookedCount < $maximum_slot) {
    //                 $timeSlots[] = $slot;
    //             }
    //         }


    //         return $timeSlots;
    //     }
    // }

    public static function convertToMinutes($durationes)
    {
        list($hours, $minutes) = explode(':', $durationes);
        return ($hours * 60) + $minutes;
    }

    public static function isSlotBooked($slot, $service, $date, $workspace)
{
    return BookingsAppointment::where('package', $service)
        ->where('date', $date)
        ->where('workspace', $workspace)
        ->where('start_time', $slot['start'])
        ->where('end_time', $slot['end'])
        ->count();
}

    // public static function isSlotBooked($slot, $service, $date, $workspace)
    // {

    //     $currentStart = Carbon::createFromFormat('H:i', $slot['start']);
    //     $currentEnd = Carbon::createFromFormat('H:i', $slot['end']);

    //     $booked_appointment = BookingsAppointment::where('package',$service)->where('date',$date)->where('workspace',$workspace)->get()->toArray();

    //     $booked_appointment = BookingsAppointment::where('start_time',$slot['start'])->where('end_time',$slot['end'])->get()->count();

    //     return $booked_appointment;

    //     // foreach ($bookedAppointments as $bookedSlot) {
    //     //     if (isset($bookedSlot['delivery_time']) && strpos($bookedSlot['delivery_time'], '-') !== false) {
    //     //         [$bookedStartTime, $bookedEndTime] = explode('-', $bookedSlot['delivery_time']);

    //     //         $bookedStart = Carbon::createFromFormat('H:i', $bookedStartTime);
    //     //         $bookedEnd = Carbon::createFromFormat('H:i', $bookedEndTime);

    //     //         if (($currentStart->gte($bookedStart) && $currentStart->lt($bookedEnd)) ||
    //     //             ($currentEnd->gt($bookedStart) && $currentEnd->lte($bookedEnd))
    //     //         ) {
    //     //             $count++;
    //     //         }
    //     //     }
    //     // }
    //     // return $count;
    // }

}
