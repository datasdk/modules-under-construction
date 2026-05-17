<?php

namespace Modules\UnderConstruction\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\BaseResource;
use Modules\UnderConstruction\Models\UnderConstruction;


class UnderConstructionController extends Controller {
    

    public function index(Request $req){


        if(!$uc = UnderConstruction::first()){ 

            $uc = UnderConstruction::firstOrCreate([
                "under_construction" => false,
                "access_key" => Str::random(15),
                "title" => "Under construction",
                "description" => "Our app is currently undergoing scheduled maintenance.We should be back shortly. Thanks for your patience.",
            ]);

        }

        return ["data" => $uc ]; // important data parameter

    }


    public function store(Request $req){


        $validator = Validator::make($req->all(),[         
            "under_construction" => "required",
            "access_key" => "required|min:5",
            "title" => "required",
            "description" => "required",     
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }


        $uc = UnderConstruction::firstOrFail();
        
        $under_construction = $req->boolean("under_construction");
        $access_key = $req->access_key;
        $title = $req->title;
        $description = $req->description;

        $has_changed = boolval($uc->under_construction) != $under_construction;



        $uc->update([
            "under_construction" => $under_construction,
            "access_key" => $access_key,
            "title" => $title,
            "description" => $description
        ]);



      

        if($under_construction){
                
            \Artisan::call("down",[
                '--refresh' => 15, 
                '--secret' => $access_key,
                '--redirect' => '/',
                   // '--render' => "maintenance"
            ]);

        } else {
                
            \Artisan::call("up");

        }
                    
      
      

        return [
            "data" => $uc->refresh()->toArray() + ["has_changed" => $has_changed]
        ];


    }


}
