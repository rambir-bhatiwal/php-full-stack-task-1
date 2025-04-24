<?php

namespace App\Http\Controllers;

use App\Models\DataHierarchy;
use Illuminate\Http\Request;

class DataHierarchyController extends Controller
{
    public function index()
    {
        $hierarchy = DataHierarchy::whereNull('parent_id')->with('children')->get();
        return view('hierarchy', compact('hierarchy'));
    }
}
