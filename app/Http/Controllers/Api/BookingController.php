<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         /**
         * return all bookings in  descending order
         */        
        return Booking::select('id', 'doctor_id', 'user_id','date','status')->orderByDesc('date')->get(); 
    }

    /**
     * create new booking .
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
                
        /**
         * validate post data
         */
        $request->validate([
                'doctor_id'   => 'required | numeric',
                'date' => 'required | date',                
            ]);
        
        /**
         * fetch inputs doctor_id, and date
        */
        $doctorId = $request->input('doctor_id');
        $date = $request->input('date');
        
        /**
         * get current logged in UserId
         */
        $userId = Auth::user()->id;
        $booking = new Booking;
        $booking->doctor_id = $doctorId;
        $booking->date = $date;        
        $booking->user_id = $userId;        
        $booking->status = "confirmed";
        
        /**
         * save new Booking
         */
        if($booking->save()){                
            return response()->json([
                "status" => '200',
                "booking" => $booking
            ]);
        }
            
    }

    /**
     * Update status of requested booking
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   $bookingId
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $bookingId)
    {
        /**
         * get booking data
         */        
        $booking = Booking::where('id',$bookingId);
        /**
         * update booking status 
         */
        $booking->update(['status' => 'canceled']);
        
         return response()->json([
                "status" => '200',
                "booking" => $booking->find($bookingId)
            ]);
        
    }

    
}
