<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\BattutaLocation;
use Validator;

class LocationFinderController extends Controller
{
    private $location;

    public function __construct()
    {
        $this->location=new BattutaLocation;
    }

    public function getCountries(Request $request)
    {
        $result=json_decode($this->location->getCountries());
        return response()->json($result);
    }

    public function getRegions(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'country'=>'required|string|min:2',
        ]);

        if($validator->fails())
            return response()->json([
                'errors'=>$validator->errors()->all()
            ],422);
        

        $result=json_decode($this->location->getRegions($request->country));
        
        return response()->json($result);
    }

    public function getCities(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'country'=>'required|string|min:2',
            'region'=>'required|string|min:3',
        ]);

        if($validator->fails())
            return response()->json([
                'errors'=>$validator->errors()->all()
            ],422);
        
        $result=json_decode($this->location->getCities($request->country,$request->region));
        
        return response()->json($result);
    }

}
