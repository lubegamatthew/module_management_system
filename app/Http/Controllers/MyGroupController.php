<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class MyGroupController extends Controller
{
    //
    public function myGroup()
    {
        $groups = Group::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })->with(['leader', 'creator', 'members'])->get();

        return view('mygroup.index', compact('groups'));
    }
}
