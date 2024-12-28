<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    // get all countries
    public function getCountries(Request $request)
    {
        $data['country_list'] = Country::all();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
}
