<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

/**
 * UserController
 *
 * This controller handles CRUD operations for users.
 *
 * @category   User Management
 * @package    App\Http\Controllers
 * @author     Muthu velan
 * @created    01-03-2025
 * @updated    01-03-2025
 */

class UserController extends Controller
{
    //This method retrieves all users from the database and returns them as a JSON response.
    public function index(): JsonResponse
    {
        return response()->json(User::all(), 200);
    }
    
    //This method is used to save the requested to the user table
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'first_name'    => 'required|string',
                'last_name'     => 'required|string',
                'role'          => 'required|in:Admin,Supervisor,Agent',
                'email'         => 'required|email|unique:users,email',
                'latitude'      => 'nullable|numeric',
                'longitude'     => 'nullable|numeric',
                'date_of_birth' => 'required|date',
                'timezone'      => 'required|string'
            ]);
    
            $user = User::create($validated);
            Log::info('User created', ['user' => $user]);//save the details to the log file
    
            return response()->json($user, 201);
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);//validation exception
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating user', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);//Error exception
        }
    
    }

    //This method is used to get the particular user detail
    public function show(User $user): JsonResponse
    {
        return response()->json($user, 200);
    }

    //This method is used to update the requested to the user table
    public function update(Request $request, User $user): JsonResponse
    {
        try {
            $validated = $request->validate([
                'first_name' => 'sometimes|required|string',
                'last_name' => 'sometimes|required|string',
                'role' => 'sometimes|required|in:Admin,Supervisor,Agent',
                'email' => ['sometimes', 'required', 'email',
                           Rule::unique('users', 'email')->ignore($user->id)],
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'date_of_birth' => 'sometimes|required|date',
                'timezone' => 'sometimes|required|string'
            ]);
    
            $user->update($validated);
            Log::info('User updated', ['user' => $user]); //save the details to the log file
    
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ], 200);
        } catch (ValidationException $e) {
            Log::error('Validation failed during update', ['errors' => $e->errors()]); //validation exception
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating user', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500); //Error exception
        }
    }

     //This method is used to delete the user
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User deleted'], 204);
    }
}
