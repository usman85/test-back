<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                
        /**
         * return id, name from from database
         */
        return Doctor::all([
                'id','name'
            ]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function availabilities(Request $request, $id)
    {                 
        $doctor = Doctor::find($id);
        // make sure doctor id exist
        if($doctor){
            // get all avalabilities of requested doctor
            return $doctor->availabilities()->get('start');                        
        }        
        if (!$doctor) {
           // return $this->error('Credentials not match', 401);
        }
        
    }


    
}
