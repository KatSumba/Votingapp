<?php

namespace App\Http\Controllers;
use App\Models\Vote;
use App\Models\Application;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index()
    {

        // $data = Vote::all();
        // $counts = DB::table('votes')->select('candidate', DB::raw('count(*) as count'))->groupBy('candidate')->get();

        // $total = count($data);

        // Fetch data from the database
        $results = Vote::select('position', 'candidate')
            ->selectRaw('count(*) as votes')
            ->groupBy('position', 'candidate')
            ->get();

        // $allCandidates =Application::select('slug','Position','ApplicationStatus')->get();
        // Fetch approved candidates from the Application table with their details

        // $candidatesData = Application::where('ApplicationStatus', 'approved')
        //     ->join('users', 'applications.FacultyID', '=', 'users.FacultyID')
        //     ->pluck('applications.slug', 'users.Firstname', 'users.LastName', 'applications.FacultyID');
        // $candidatesData = Application::where('ApplicationStatus', 'approved')
        //     ->join('users', 'applications.FacultyID', '=', 'users.FacultyID')
        //     ->select('users.FirstName', 'users.LastName', 'applications.FacultyID', 'applications.slug', 'applications.Position')
        //     ->get();

        $candidatesData = Application::where('ApplicationStatus', 'approved')
            ->join('users', 'applications.FacultyID', '=', 'users.FacultyID')
            ->pluck('users.FirstName', 'users.LastName', 'applications.FacultyID', 'applications.slug', 'applications.Position');
        
        // Prepare data for Chart.js
        $positions = $results->pluck('position')->unique();
        //$candidates = $results->pluck('candidate')->unique();
        // $data = [];
        $chartsData = [];

        foreach ($positions as $position) {
            $positionVotes = $results->where('position', $position);
            // $candidates = $positionVotes->pluck('candidate')->unique();
            // $candidates = $allCandidates->where('Position', $position)
            //     ->where('ApplicationStatus', 'approved')
            //     ->pluck('slug');
            $candidates = $candidatesData->keys()->toArray();
            $votes = $positionVotes->pluck('votes');
            // $votes =[];

            foreach ($candidates as $candidate) {
                $votes[] = $positionVotes->where('candidate', $candidate)->first()->votes ?? 0;
                
            }


            $chartsData[] = [
                'position' => $position,
                'candidates' => $candidates,
                'votes' => $votes,
            ];
        }


        return view ('auth.result' , compact('chartsData', 'candidates', 'candidatesData'));
    }
}
