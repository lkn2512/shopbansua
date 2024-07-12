<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProvinceCity;
use App\Models\District;
use App\Models\Wards;

class AddressController extends Controller
{
    public function getProvinces()
    {
        $provinces = ProvinceCity::all();
        return response()->json($provinces);
    }

    public function getDistricts($province_id)
    {
        $districts = District::where('matp', $province_id)->get();
        return response()->json($districts);
    }

    public function getWards($district_id)
    {
        $wards = Wards::where('maqh', $district_id)->get();
        return response()->json($wards);
    }
}
