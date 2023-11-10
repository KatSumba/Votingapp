<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\Positions;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $applications = Application::select('ApplicationID','FacultyID', 'Manifesto', 'Position','Slogan', 'ApplicationStatus','created_at', 'updated_at')->get();
            
            return DataTables::of($applications)
                ->addColumn('action', function ($application) {
                    return '<button class="btn btn-primary btn-sm btn-edit mr-2"
                        FacultyID="' . $application->FacultyID . '" 
                        ApplicationID="' . $application->ApplicationID . '"
                        Manifesto="' . $application->Manifesto . '" 
                        Position="' . $application->Position . '" 
                        Slogan="' . $application->Slogan . '" 
                        ApplicationStatus="' . $application->ApplicationStatus . '"  >
                        <i class="fa-solid fa-pencil"></i>
                    </button>' .
                    '<button class="btn btn-danger btn-sm btn-delete mr-2" 
                        ApplicationID="' . $application->ApplicationID . '" 
                        FacultyID="' . $application->FacultyID . '" >
                        <i class="fa-solid fa-trash"></i>
                    </button>';
                })
                // ->editColumn('FacultyID', function($application){
                //     $user = User::find($application->FacultyID);
                //     return $user ? $user->FirstName : 'User not found';
                // })
                // ->editColumn('FacultyID', function($application){
                //     $user = User::where('FacultyID', $application->FacultyID)
                //     ->select('FacultyID', 'FirstName', 'LastName')
                //     ->get();
                //     return $user->FacultyID . ' - ' . $user->FirstName . ' ' . $user->LastName;
                // })
                ->editColumn('ApplicationStatus', function($application){
                    if ($application->ApplicationStatus =='approved'){
                        return '<span class="rounded p-1 text-success"style="background-color: rgba(25, 135, 84, 0.1); border-radius: 50%;">approved</span>';
                    }
                    elseif($application->ApplicationStatus =='rejected'){
                        return '<span class="rounded p-1 text-danger"style="background-color: rgba(220,53,69,.1); border-radius: 50%;">rejected</span>';
                    }
                    elseif($application->ApplicationStatus =='pending'){
                        return '<span class="rounded p-1 text-secondary"style="background-color: rgba(200,200,200,.1); border-radius: 50%;">pending</span>';
                    }
                })
                ->editColumn('DateCreated', function ($application) {
                    // Format the DateCreated column to 'Y-m-d H:i:s' format
                    return Carbon::parse($application->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('LastUpdated', function ($application) {
                    // Format the LastUpdated column to 'Y-m-d H:i:s' format
                    return Carbon::parse($application->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action','ApplicationStatus', 'DateCreated', 'LastUpdated'])
                ->make(true);
        }
        $users = User::where('role', 0)->get();
        $positions= Positions::all();
        return view('admin.application', compact('users','positions'));
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
    function generateUniqueSlug($length=10){
        do{
            $slug=Str::random($length);
        }while(Application::where('slug',$slug)->exists());
    
        return $slug;
    }
    public function store(Request $request)
    {
        $slug=$this->generateUniqueSlug();
        
        // Add the unique slug to the request data
        $request->merge(['slug' => $slug]);

        $data=request()->validate([
            'userId'=>'required',
            'Manifesto'=>'required |min:150',
            'positions' =>'required',
            'Slogan'=>'required',
            'slug' => '',
        ]);
        $existingApplication = Application::where('FacultyID', $request->input('userId'))->first();

        if ($existingApplication) {
            // An application with the same FacultyID already exists
            Session::flash('notification',[
                'message' => 'This candidate already has an application.',
                'alert-type' => 'error',
            ]);        
        }else{
            try {
            
                Application::create([
                    'FacultyID' =>$data['userId'],
                    'Manifesto' =>$data['Manifesto'],
                    'Position' =>$data['positions'],
                    'Slogan' => $data['Slogan'],
                    'slug' => $data['slug'],
                ]);
                Session::flash('notification',[
                    'message' => 'Application created successfully',
                    'alert-type' => 'success',
                ]);
            } catch (\Throwable $th) {
                Session::flash('notification',[
                    'message' => 'Error creating application',
                    'alert-type' => 'error',
                ]);
            }

        }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $data=request()->validate([
            'ApplicationID'=>'required',
            'Manifesto'=>'required |min:150',
            'Position' =>'required',
            'Slogan'=>'required',
            'ApplicationStatus'=>'required',
        ]);

        try { 
            Application::where('ApplicationID',$request->ApplicationID)->update($request->except(['_token','_method']));

            
            $res = ['status'=> 1];
        } catch (\Throwable $th) {
            $res = ['status'=> 0];
        }
        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Application $application)
    {
        try {
            Application::where('ApplicationID', $request->del_ID)->delete();
                $res = ['status' => 1, 'message' => 'Application deleted successfully.'];
            
        } catch (\Throwable $th) {
            $res = ['status'=> 0];
        }
    }
}
