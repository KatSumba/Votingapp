<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Models\Positions;
use App\Models\Application;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BallotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications=Application::where('ApplicationStatus', 'approved')->get();
        //$positions= Positions::all();
        $positions = Application::where('ApplicationStatus', 'approved')
        ->select('position')
        ->distinct()
        ->get();
        $infos=User::where('role','0')->get();

        $userId = auth()->id();
        $existingVote = Vote::where('voter', $userId)->first();
        
        return view ('students.ballot', compact('applications','positions','infos','existingVote'));
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
        // dd($request->all());
        $userId = auth()->id();
        $existingVote = Vote::where('voter', $userId)->first();

        if ($existingVote) {
            // An application with the same FacultyID already exists
            Session::flash('notification',[
                'message' => 'You have already voted',
                'alert-type' => 'error',
            ]);        
        }else{
            foreach ($request->except('_token') as $key => $value) {
                // Extract the vote ID and save it to the database
                $voteId = $value;
                $data= Application::where('slug',$voteId)
                ->first();

                // Save the data to the Vote model or your relevant model
                Vote::create([
                    'voter' => $userId,
                    'candidate' => $voteId,
                    'position' =>$data['Position'],
                ]);
            }
            Session::flash('notification',[
                'message' => 'You vote has been registered',
                'alert-type' => 'success',
            ]); 
        }
        
        return redirect()->back();
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
