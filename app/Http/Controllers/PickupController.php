<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;

class PickupController extends Controller
{
    private $pickup;

    public function __construct(Pickup $pickup){
        $this->pickup = $pickup;
    }

    public function store($project_id){
        $this->pickup->project_id = $project_id;
        $this->pickup->save();

        return redirect()->back();
    }

    public function destroy($project_id){
        $this->pickup->where('project_id', $project_id)->delete();

        return redirect()->back();
    }
}
