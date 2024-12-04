<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    function home()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Employee dashboard'
        ], 200);
    }

    public function createEmployee(Request $request)
    {



        DB::beginTransaction();

        try {

            $validated = $request->validate([
                'fast_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20|unique:users,phone',
                'password' => 'required|string|min:6',
                'national_id' => 'required|string|unique:employees,national_id',
                'salary' => 'required|integer',
                'joining_date' => 'nullable|date',
            ]);

            $user = User::create([
                'fast_name' => $validated['fast_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'] ?? 'employee',
            ]);

            $employee = Employee::create([
                'user_id' => $user->id,
                'national_id' => $validated['national_id'],
                'salary' => $validated['salary'],
                'joining_date' => $validated['joining_date'] ?? null,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Employee created successfully',
                'data' => [
                    'user' => $user,
                    'employee' => $employee
                ]
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create employee',
            ]);
        }
    }

    public function showEmployee(Request $request)
    {

        $employee = Employee::with('user')->find($request->input('id'));

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Employee details',
            'data' => $employee
        ], 200);

    }

    public function updateEmployee(Request $request, $id)
    {

        $validated = $request->validate([
            'fast_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $id . ',id',
            'password' => 'nullable|string|min:6',
            'national_id' => 'nullable|string|unique:employees,national_id,' . $id . ',id',
            'salary' => 'nullable|integer',
            'joining_date' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {

            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json([
                    'message' => 'Employee not found',
                    'status' => 'error',
                ], 404);
            }


            $user = $employee->user;
            $user->update(array_filter([
                'fast_name' => $validated['fast_name'] ?? $user->fast_name,
                'last_name' => $validated['last_name'] ?? $user->last_name,
                'phone' => $validated['phone'] ?? $user->phone,
                'password' => isset($validated['password']) ? bcrypt($validated['password']) : $user->password,
            ]));


            $employee->update(array_filter([
                'national_id' => $validated['national_id'] ?? $employee->national_id,
                'salary' => $validated['salary'] ?? $employee->salary,
                'joining_date' => $validated['joining_date'] ?? $employee->joining_date,
            ]));

            DB::commit();

            return response()->json([
                'message' => 'Employee updated successfully',
                'status' => 'success',
                'data' => $employee,
            ]);
        } catch (Exception $e) {
            DB::rollBack(); // সমস্যা হলে রোলব্যাক
            return response()->json([
                'message' => 'Failed to update employee',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteEmployee(Request $request)
    {
        DB::beginTransaction();

        try {

            $employee = Employee::where('user_id', $request->input('user_id'))->first();

            if (!$employee) {
                return response()->json([
                    'message' => 'Employee not found',
                    'status' => 'error',
                ], 404);
            }

            $employee->delete();
            $user = $employee->user;
            $user->delete();

            DB::commit();

            return response()->json([
                'message' => 'Employee deleted successfully',
                'status' => 'success',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete employee',
                'status' => 'error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
