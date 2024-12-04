<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Exception;

class LocationController extends Controller
{
    //
        // Create method
        public function Create(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'district' => 'required|string|max:255',
                'division' => 'required|string|max:255',
            ]);
    
            try {
                $location = Location::create([
                    'name' => $request->name,
                    'district' => $request->district,
                    'division' => $request->division,
                ]);
        
                return response()->json(['message' => 'Location created successfully', 'location' => $location], 201);
            }catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to create location',
                    'status' => 'error',
                ], 500);
            }
           
        }
    
        // Update method
        public function Update(Request $request, $id)
        {
            $location = Location::find($id);
    
            if (!$location) {
                return response()->json(['message' => 'Location not found'], 404);
            }
    
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'district' => 'sometimes|string|max:255',
                'division' => 'sometimes|string|max:255',
            ]);
    
            try{
                $location->update([
                    'name' => $request->name ?? $location->name,
                    'district' => $request->district ?? $location->district,
                    'division' => $request->division ?? $location->division,
                ]);
        
                return response()->json(['message' => 'Location updated successfully', 'location' => $location]);
            }catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to update location',
                    'status' => 'error',
                ], 500);
            }
           
        }
    
        // Delete method
        public function Delete($id)
        {
            $location = Location::find($id);
    
            if (!$location) {
                return response()->json(['message' => 'Location not found'], 404);
            }

            try{
                $location->delete();
    
                return response()->json(['message' => 'Location deleted successfully']);
            }catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to delete location',
                    'status' => 'error',
                ], 500);
            }
           
        }

        public function LocationById(Request $request)
        {
            $location_id = $request->input('id');
    
            $location = Location::find($location_id);
    
            if ($location) {
                return response()->json($location); 
            } else {
                return response()->json(['message' => 'Location not found'], 404); 
            }
        }
    
        public function SelectAllLocation(Request $request)
        {
            $all_location = Location::all();
            if ($all_location) {
                return response()->json($all_location); 
            } else {
                return response()->json(['message' => 'Location not found'], 404); 
            }
        }
    
}
