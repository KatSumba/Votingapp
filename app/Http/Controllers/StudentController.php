<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('role', '0')->select('FirstName', 'LastName', 'FacultyID', 'EnrollmentStatus','role', 'email', 'created_at', 'updated_at')->get();
            
            return DataTables::of($users)
                            ->addColumn('action', function ($user) {
                        return '<button class="btn btn-primary btn-sm btn-edit mr-2" 
                                FirstName="' . $user->FirstName . '"
                                LastName="' . $user->LastName . '" 
                                FacultyID="' . $user->FacultyID . '" 
                                EnrollmentStatus="' . $user->EnrollmentStatus . '" 
                                role="' . $user->role . '" 
                                email="' . $user->email . '"  >
                                <i class="fa-solid fa-pencil"></i>
                            </button>' .
                            '<button class="btn btn-danger btn-sm btn-delete mr-2" 
                                FacultyID="' . $user->FacultyID . '" >
                                <i class="fa-solid fa-trash"></i>
                            </button>';
                    })
                ->editColumn('role', function($user){
                    if($user->role=='0'){
                        return 'student';
                    }
                    elseif($user->role=='1'){
                        return 'admin';
                    }
                })
                ->editColumn('EnrollmentStatus', function($user){
                    if ($user->EnrollmentStatus =='active'){
                        return '<span class="rounded p-1 text-success"style="background-color: rgba(25, 135, 84, 0.1); border-radius: 50%;">Active</span>';
                    }
                    elseif($user->EnrollmentStatus =='inactive'){
                        return '<span class="rounded p-1 text-danger"style="background-color: rgba(220,53,69,.1); border-radius: 50%;">Inactive</span>';
                    }
                })
                ->editColumn('DateCreated', function ($user) {
                    // Format the DateCreated column to 'Y-m-d H:i:s' format
                    return Carbon::parse($user->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('LastUpdated', function ($user) {
                    // Format the LastUpdated column to 'Y-m-d H:i:s' format
                    return Carbon::parse($user->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['EnrollmentStatus', 'action','role', 'DateCreated', 'LastUpdated'])
                ->make(true);
        }
        
        return view('admin.managestudents');
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
    public function update(Request $request, User $user)
    {
        $data=request()->validate([
            'FirstName'=>'required',
            'LastName'=>'required',
            'FacultyID'=>' required',
            'EnrollmentStatus'=>' required',
            'email'=>' required',
        ]);
        try { 
            User::where('FacultyID',$request->FacultyID)->update($request->except(['_token','_method']));

            $res = ['status'=> 1];
        } catch (\Throwable $th) {
            $res = ['status'=> 0];
        }
        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try { 
            User::where('FacultyID',$request->del_ID)
            ->delete();
            
            $res = ['status'=> 1];
        } catch (\Throwable $th) {
            $res = ['status'=> 0];
        }
        return $res;
            
    }
}
