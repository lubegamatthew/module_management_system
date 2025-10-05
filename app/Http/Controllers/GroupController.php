<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{
    //
    public function createMember()
    {
        return view('groups.add_member');
    }
    public function viewMembers()
    {
        $users = User::all();
        // $users = User::where('login_status', 1)->get();
        return view('groups.members', compact('users'));
    }
    public function saveMember(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15',
                'course' => 'required|string|max:100',
                'gender' => 'required|string',
            ]);

            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'course' => $validated['course'],
                'gender' => $validated['gender'],
                'password' => bcrypt('P4ssw0rd!'),
                'login_status' => '0',
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Member added successfully.'
                ]);
            }

            return redirect()
                ->route('members.view')
                ->with('success', 'Member added successfully.');

        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()
                ->withInput()
                ->with('error', 'Validation failed. Please check your inputs.');
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An unexpected error occurred: ' . $e->getMessage(),
                ], 500);
            }

            return back()
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
    public function createGroup()
    {
        $usedUserIds = DB::table('group_user')->pluck('user_id')->toArray();
        $members = User::whereNotIn('id', $usedUserIds)->get(['id', 'name']);
        return view('groups.create_group', compact('members'));
    }

    public function storeGroup(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'members' => 'required|array|min:1',
            'leader' => 'required|exists:users,id',
        ]);

        $group = Group::create([
            'name' => $validated['group_name'],
            'leader_id' => $validated['leader'],
            'created_by' => auth()->id(), 
        ]);

        $group->members()->sync($validated['members']);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Group created successfully!'
            ]);
        }

        return redirect()->route('groups.view')->with('success', 'Group created successfully!');
    }
    public function viewGroups()
    {
        $groups = Group::with(['leader', 'creator', 'members'])
               ->orderBy('created_at', 'asc')
               ->get();
        return view('groups.view_groups', compact('groups'));
    }

}
