<?php

namespace App\Http\Controllers;

use App\Models\Positions;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $applications=Application::where('ApplicationStatus', 'approved')->get();
        //$positions= Positions::all();
        $positions = Application::where('ApplicationStatus', 'approved')->distinct()->pluck('position')->toArray();
        $infos=User::where('role','0')->get();
        
        return view('students.candidates', compact('applications','positions','infos'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
