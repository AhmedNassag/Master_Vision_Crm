<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Models\Activate;
use App\Models\Interest;
use Illuminate\Http\Request;
use App\Models\PointsSetting;

class PointsSettingController extends Controller
{
     // Display a listing of the resource
     public function index()
     {
         $pointsSettings = PointsSetting::paginate(10);
         $activities = Activate::all();
        $subActivities = Interest::all();
         return view('la.pointsSettings.index', compact('pointsSettings','activities','subActivities'));
     }

     // Show the form for creating a new resource
     public function create()
     {
         return view('la.pointsSettings.create');
     }

     // Store a newly created resource in storage
     public function store(Request $request)
     {
         $request->validate([
             'conversion_rate' => 'required|numeric',
             'sales_conversion_rate' => 'required|numeric',
             'points' => 'required|integer',
             'expiry_days' => 'required',
         ]);
         $inputData = $request->all();

        // Iterate through each element and replace empty strings with null
        $filteredData = array_map(function ($value) {
            return $value === "" ? null : $value;
        }, $inputData);

         PointsSetting::create($filteredData);

         return redirect()->route('admin.pointsSettings.index')
             ->with('success', 'Points setting created successfully.');
     }

     // Display the specified resource
     public function show(PointsSetting $pointsSetting)
     {
         return view('la.pointsSettings.show', compact('pointsSetting'));
     }

     // Show the form for editing the specified resource
     public function edit(PointsSetting $pointsSetting)
     {

        $activities = Activate::all();
       $subActivities = Interest::all();
         return view('la.pointsSettings.edit', compact('pointsSetting','activities','subActivities'));
     }

     // Update the specified resource in storage
     public function update(Request $request, PointsSetting $pointsSetting)
     {
         $request->validate([
             'conversion_rate' => 'required|numeric',
             'sales_conversion_rate' => 'required|numeric',
             'points' => 'required|integer',
             'expiry_days' => 'required',
         ]);

         $inputData = $request->all();

         $filteredData = array_map(function ($value) {
            return $value === "" ? null : $value;
        }, $inputData);

         $pointsSetting->update($filteredData);

         return redirect()->route('admin.pointsSettings.index')
             ->with('success', 'Points setting updated successfully.');
     }

     // Remove the specified resource from storage
     public function destroy(PointsSetting $pointsSetting)
     {
         $pointsSetting->delete();

         return redirect()->route('admin.pointsSettings.index')
             ->with('success', 'Points setting deleted successfully.');
     }
}
