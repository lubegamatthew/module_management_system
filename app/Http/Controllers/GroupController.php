<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
