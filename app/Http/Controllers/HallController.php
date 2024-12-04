<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hall;
use Exception;

class HallController extends Controller
{
    //

    public function create(Request $request)
    {
        $request->validate([
            'hall_name' => 'required|string|max:255',
            'hall_address' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'normal_seat_row' => 'required|string|max:255',
            'normal_seat_column' => 'required|string|max:255',
            'premium_seat_row' => 'required|string|max:255',
            'premium_seat_column' => 'required|string|max:255',
            'premium_seat_price' => 'required|numeric|max:255',
            'normal_seat_price' => 'required|numeric|max:255',
            'location_id' => 'required|exists:locations,id',
        ]);

        try {
            $hall = Hall::create([
                'hall_name' => $request->hall_name,
                'hall_address' => $request->hall_address,
                'phone_number' => $request->phone_number,
                'normal_seat_row' => $request->normal_seat_row,
                'normal_seat_column' => $request->normal_seat_column,
                'premium_seat_row' => $request->premium_seat_row,
                'premium_seat_column' => $request->premium_seat_column,
                'premium_seat_price' => $request->premium_seat_price,
                'normal_seat_price' => $request->normal_seat_price,
                'location_id' => $request->location_id,

            ]);
    
            return response()->json(['message' => 'Hall created successfully', 'hall' => $hall], 201);
        }catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create hall',
                'status' => 'error',
            ], 500);
        }
       
    }

    // Update method
    public function update(Request $request, $id)
    {
        $hall = Hall::find($id);

        if (!$hall) {
            return response()->json(['message' => 'hall not found'], 404);
        }

        $request->validate([
                'hall_name' => 'required|string|max:255',
                'hall_address' => 'required|string|max:255',
                'phone_number' => 'required|numeric', 
                'normal_seat_row' => 'required|string|max:255',
                'normal_seat_column' => 'required|string|max:255',
                'premium_seat_row' => 'required|string|max:255',
                'premium_seat_column' => 'required|string|max:255',
                'premium_seat_price' => 'required|numeric', 
                'normal_seat_price' => 'required|numeric', 
                'location_id' => 'required|exists:locations,id',
        ]);

        try{
            $hall->update([
                'hall_name' => $request->hall_name ?? $hall->hall_name,
                'hall_address' => $request->hall_address ?? $hall->hall_address,
                'phone_number' => $request->phone_number ?? $hall->phone_number,
                'normal_seat_row' => $request->normal_seat_row ?? $hall->normal_seat_row,
                'normal_seat_column' => $request->normal_seat_column ?? $hall->normal_seat_column,
                'premium_seat_row' => $request->premium_seat_row ?? $hall->premium_seat_row,
                'premium_seat_column' => $request->premium_seat_column ?? $hall->premium_seat_column,
                'premium_seat_price' => $request->premium_seat_price ?? $hall->premium_seat_price,
                'normal_seat_price' => $request->normal_seat_price ?? $hall->normal_seat_price,
                'location_id' => $request->location_id ?? $hall->location_id,

            ]);
    
            return response()->json(['message' => 'hall updated successfully', 'hall' => $hall]);
        }catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update hall',
                'status' => 'error',
            ], 500);
        }
       
    }

    // Delete method
    public function delete($id)
    {
        $hall = Hall::find($id);

        if (!$hall) {
            return response()->json(['message' => 'hall not found'], 404);
        }

        try{
            $hall->delete();

            return response()->json(['message' => 'hall deleted successfully']);
        }catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete hall',
                'status' => 'error',
            ], 500);
        }
       
    }

    public function HallById(Request $request)
    {
        $hall_id = $request->input('id');

        $hall = Hall::find($hall_id);

        if ($hall) {
            return response()->json($hall); 
        } else {
            return response()->json(['message' => 'Hall not found'], 404); 
        }
    }

    public function SelectAllHall(Request $request)
    {
        $all_hall = Hall::all();
        if ($all_hall) {
            return response()->json($all_hall); 
        } else {
            return response()->json(['message' => 'Hall not found'], 404); 
        }
    }
}

