<?php

namespace App\Http\Controllers;

use DataTables;

use App\Models\Positions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $positions = Positions::select('id', 'name', 'created_at', 'updated_at')->get();
            
            return DataTables::of($positions)
                            ->addColumn('action', function ($position) {
                        return '<button class="btn btn-primary btn-sm btn-edit mr-2" 
                                ID="' . $position->id . '"
                                name="' . $position->name . '" >
                                <i class="fa-solid fa-pencil"></i>
                            </button>' .
                            '<button class="btn btn-danger btn-sm btn-delete mr-2" 
                                ID="' . $position->id . '"
                                name="' . $position->name . '">
                                <i class="fa-solid fa-trash"></i>
                            </button>';
                    })
                ->editColumn('DateCreated', function ($position) {
                    // Format the DateCreated column to 'Y-m-d H:i:s' format
                    return Carbon::parse($position->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('LastUpdated', function ($position) {
                    // Format the LastUpdated column to 'Y-m-d H:i:s' format
                    return Carbon::parse($position->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'DateCreated', 'LastUpdated'])
                ->make(true);
        }
        
        return view('admin.position');
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
        }while(Positions::where('slug',$slug)->exists());
    
        return $slug;
    }
    public function store(Request $request)
    {

        $slug=$this->generateUniqueSlug();
        
        // Add the unique slug to the request data
        $request->merge(['slug' => $slug]);

        $data=request()->validate([
            'name'=>'required',
            'slug' => '',
        ]);

        $exists=Positions::where('name',$request->input('name'))->first();

        if($exists){
            Session::flash('notification',[
                'message' => 'This position already exists.',
                'alert-type' => 'error',
            ]);   
        } else{
            try {
                Positions::create([
                    'name'=>$data['name'],
                ]);

                Session::flash('notification',[
                    'message' => 'Position created successfully',
                    'alert-type' => 'success',
                ]);
            } catch (\Throwable $th) {
                Session::flash('notification',[
                    'message' => 'Error creating position',
                    'alert-type' => 'error',
                ]);
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Positions $positions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Positions $positions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Positions $positions)
    {
        $data=request()->validate([
            'name'=>'required',
        ]);

        try {
            Positions::where('id',$request->id)->update($request->except(['_token','_method']));

            
            $res = ['status'=> 1];
        } catch (\Throwable $th) {
            $res = ['status'=> 0];
        }
        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Positions $positions)
    {
        try {
            Positions::where('id', $request->del_ID)->delete();
                $res = ['status' => 1];
            
        } catch (\Throwable $th) {
            $res = ['status'=> 0];
        }
    }
}
