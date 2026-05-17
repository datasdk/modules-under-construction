<?php

namespace Modules\UnderConstruction\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\UnderConstruction\Models\UnderConstruction;

class UnderConstructionController extends Controller
{
    /**
     * Show the edit form for Under Construction settings.
     */
    public function edit()
    {
        $uc = UnderConstruction::first();

        if (!$uc) {
            $uc = UnderConstruction::create([
                "under_construction" => false,
                "access_key" => Str::random(15),
                "title" => "Under construction",
                "description" => "Our app is currently undergoing scheduled maintenance. We should be back shortly. Thanks for your patience.",
            ]);
        }

        return view('underconstruction::edit', compact('uc'));
    }

    /**
     * Store the updated Under Construction settings.
     */
    public function store(Request $req)
    {
        $req->validate([
            "under_construction" => "required|boolean",
            "access_key" => "required|min:5",
            "title" => "required|string",
            "description" => "required|string",
        ]);

        $uc = UnderConstruction::firstOrFail();

        $under_construction = $req->boolean("under_construction");
        $access_key = $req->access_key;
        $title = $req->title;
        $description = $req->description;

        $has_changed = boolval($uc->under_construction) !== $under_construction;

        $uc->update([
            "under_construction" => $under_construction,
            "access_key" => $access_key,
            "title" => $title,
            "description" => $description,
        ]);

        // Put application in maintenance mode or bring it up
        if ($under_construction) {
            \Artisan::call("down", [
                '--refresh' => 15,
                '--secret' => $access_key,
                '--redirect' => '/',
            ]);
        } else {
            \Artisan::call("up");
        }

        return redirect()->route('settings.under_construction.edit')
                         ->with('success', 'Under Construction settings updated successfully.');
    }
}
