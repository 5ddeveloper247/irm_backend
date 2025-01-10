<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkLocation;
class LocationController extends Controller
{
    //getLocations
    public function getLocations(Request $request)
    {
        // locations with lat and long
        // $locations = [
        //     ['name' => "Karachi", 'coords' => ['lat' => 24.8607, 'lng' => 67.0011], 'color' => "#FF0000", 'lat' => 24.8607, 'lng' => 67.0011, 'descriptions' => 'Karachi is the largest city in Pakistan and the twelfth largest city in the world. It is the capital of the Pakistani province of Sindh. Ranked as a beta-global city, it is Pakistan\'s premier industrial and financial centre.'],
        //     ['name' => "Lahore", 'coords' => ['lat' => 31.5497, 'lng' => 74.3436], 'color' => "#00FF00", 'lat' => 31.5497, 'lng' => 74.3436, 'descriptions' => 'Lahore is the capital of the Pakistani province of Punjab. It is the country\'s 2nd largest city after Karachi and 18th largest city proper in the world.'],
        //     ['name' => "Islamabad", 'coords' => ['lat' => 33.6844, 'lng' => 73.0479], 'color' => "#0000FF", 'lat' => 33.6844, 'lng' => 73.0479, 'descriptions' => 'Islamabad is the capital city of Pakistan, and is federally administered as part of the Islamabad Capital Territory. Built as a planned city in the 1960s to replace'],
        //     ['name' => "Quetta", 'coords' => ['lat' => 30.1798, 'lng' => 66.9750], 'color' => "#FFFF00", 'lat' => 30.1798, 'lng' => 66.9750, 'descriptions' => 'Quetta is the provincial capital and largest city of Balochistan, Pakistan. It is also the 10th largest city of Pakistan.'],
        //     ['name' => "Peshawar", 'coords' => ['lat' => 34.0151, 'lng' => 71.5249], 'color' => "#FF00FF", 'lat' => 34.0151, 'lng' => 71.5249, 'descriptions' => 'Peshawar is the capital of the Pakistani province of Khyber Pakhtunkhwa. Situated in the broad Valley of Peshawar near the eastern end of the historic Khyber Pass, close to the border with Afghanistan.'],
        //     // Gujrat
        //     ['name' => "Gujrat", 'coords' => ['lat' => 32.1622, 'lng' => 74.1883], 'color' => "#FF00FF", 'lat' => 32.1622, 'lng' => 74.1883, 'descriptions' => 'Gujrat is a city in the Punjab Province of Pakistan. It is the capital of Gujrat District and the 18th largest city of Pakistan.'],
        // ];
        $locations = WorkLocation::where('status', 1)->get();
        return response()->json(['status' => 'success', 'data' => $locations]);
    }
}
