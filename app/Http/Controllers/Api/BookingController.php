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
        return Booking::select('id', 'doctor_id', 'user_id', 'date', 'status')->orderByDesc('date')->get();

        // Use resource instead of Select
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

        // Use Form Request

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
        $booking->status = "confirmed"; // maybe use a constant

        /**
         * save new Booking
         */
        if ($booking->save()) {
            // why would this fail? What is returned if it fails?
            return response()->json([
                "status" => '200',
                "booking" => $booking
            ]);

            // An API should return the resource, the status code is returned with the request. It is not necessary here
        }
    }

    /**
     * Update status of requested booking
     *
     * @param  \Illuminate\Http\Request  $request
     * @param    $bookingId
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $bookingId)
    // is this to cancel or update status?
    {
        /**
         * get booking data
         */
        $booking = Booking::where('id', $bookingId);

        // ->get() ?

        /**
         * update booking status 
         */
        $booking->update(['status' => 'canceled']); // Maybe we can use constant for the value

        return response()->json([
            "status" => '200',
            "booking" => $booking->find($bookingId) // Why refetch?
        ]);
    }
}
