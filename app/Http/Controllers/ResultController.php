<?php

namespace App\Http\Controllers;
use App\Models\Vote;
use App\Models\Application;
use App\Models\User;
use PDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index()
    {

        $votesExist = Vote::exists();

        // If no votes exist, return a view with a message
        if (!$votesExist) {
            return view('auth.no-data');
        }
        // $data = Vote::all();
        // $counts = DB::table('votes')->select('candidate', DB::raw('count(*) as count'))->groupBy('candidate')->get();

        // $total = count($data);

        // Fetch data from the database
        // $results = Vote::select('position', 'candidate')
        //     ->selectRaw('count(*) as votes')
        //     ->groupBy('position', 'candidate')
        //     ->get();
        $results = Vote::select('position', 'candidate','FirstName', 'LastName')
        ->selectRaw('count(*) as votes')
        ->groupBy('position', 'candidate','FirstName', 'LastName')
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

        // $candidatesData = Application::where('ApplicationStatus', 'approved')
        //     ->join('users', 'applications.FacultyID', '=', 'users.FacultyID')
        //     ->pluck('users.FirstName', 'users.LastName', 'applications.FacultyID', 'applications.slug', 'applications.Position');
        
        $candidatesData = Application::where('ApplicationStatus', 'approved')
        ->select('Position', 'FacultyID')
        ->get();
    
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

            //get candidates data for this position
            $cpData=$candidatesData->where('Position', $position)->pluck('FacultyID');
            

            $candidates = $cpData->values()->toArray();

            $votes = $positionVotes->pluck('votes');
            $votes =[];
            $infos=[];

            foreach ($candidates as $candidate) {
                $votes[] = $positionVotes->where('candidate', $candidate)->first()->votes ?? 0;
                $ID=User::where('FacultyID',$candidate)
                    ->pluck('FacultyID');
                    $FirstName=User::where('FacultyID',$candidate)
                    ->pluck('FirstName');
                    $LastName=User::where('FacultyID',$candidate)
                    ->pluck('LastName');
                  $info=$ID[0].' '.$FirstName[0].' '.$LastName[0];  
                $infos[]=$info;
                  
            }


            $chartsData[] = [
                'position' => $position,
                'candidates' => $infos,
                'votes' => $votes,
            ];
        }


        return view ('auth.result' , compact('chartsData', 'candidates', 'candidatesData'));
    }
    // public function collectVotesData()
    // {
    //     // Collect data from the 'votes' table
    //     $votesData = Vote::select('position', 'candidate')
    //         ->get();

    //     // Group data based on position and candidate
    //     // $groupedData = $votesData->groupBy(['position', 'candidate']);
    //     $groupedData = $votesData->groupBy(['position']);

    //     // Initialize an array to store the final result
    //     $result = [];
    //     // dd($votesData);
    //     // Loop through each group
    //     foreach ($groupedData as $position => $positionData) {
    //         // Count the occurrences of each candidate in the group
    //         $candidateCounts = $positionData->countBy('candidate');
            
    //         // Transform the data into an array with candidates and counts
    //         $candidatesData = $candidateCounts->map(function ($count, $candidateId) {
    //             return [
    //                 'candidate' => $candidateId,
    //                 'count' => $count,
    //             ];
    //         })->all();
            
    //         // Calculate the total votes for the position
    //         $totalVotes = $positionData->count();

    //         // Build the result array for this position
    //         $result[] = [
    //             'position' => $position,
    //             'candidates' => $candidatesData,
    //             'total_votes' => $totalVotes,
    //         ];
    //     }

    //     // Output the result
    //     return $result;
    // }

    public function collectVotesData()
{
    // Collect data from the 'votes' table
    $votesData = Vote::select('position', 'candidate')->get();

    // Group data based on position
    $groupedData = $votesData->groupBy('position');

    // Initialize an array to store the final result
    $result = [];

    // Loop through each group
    foreach ($groupedData as $position => $positionData) {
        // Collect data from the 'application' table where status is accepted for the specific position
        $acceptedCandidates = Application::where('ApplicationStatus', 'approved')
            ->where('position', $position)
            ->pluck('FacultyID')
            ->toArray();
        // Count the occurrences of each candidate in the group
        $candidateCounts = $positionData->countBy('candidate');

        // Add counts for candidates from accepted applications with 0 votes
        foreach ($acceptedCandidates as $acceptedCandidate) {
            if (!isset($candidateCounts[$acceptedCandidate])) {
                $candidateCounts[$acceptedCandidate] = 0;
            }
        }

        // Transform the data into an array with candidates and counts
        $candidatesData = $candidateCounts->map(function ($count, $candidateId) {
            return [
                'candidate' => $candidateId,
                'count' => $count,
            ];
        })->all();

        // Calculate the total votes for the position
        $totalVotes = $positionData->count();

        // Build the result array for this position
        $result[] = [
            'position' => $position,
            'candidates' => $candidatesData,
            'total_votes' => $totalVotes,
        ];
    }

    // Output the result
    return $result;
}
    public function exportVotesDataToPDF()
    {
        // Use the previously defined function to collect the votes data
        $votesData = $this->collectVotesData();

        // Generate PDF using DomPDF
        $pdf = PDF::loadView('auth.export_pdf', compact('votesData'));

        // Save or download the PDF
        return $pdf->download('EVoting_results.pdf');
    }
}
