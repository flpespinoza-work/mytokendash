<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        return view('admin.group.index');
    }

    public function create()
    {
        return view('admin.group.create');
    }

    public function show(Group $group)
    {
        return view('admin.group.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('admin.group.edit', compact('group'));
    }

    public function store(Group $group)
    {
        return view('admin.group.store', compact('group'));
    }

}
