<!-- Your Blade view file, e.g., resources/views/votes/export_pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Votes Data</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        h1 {
            text-align: center;
        }

        .card-container {
            display: flex;
            justify-content: center;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            width: 80%; /* Adjust the width as needed */
        }

        h2 {
            color: #333;
        }

        p {
            margin: 10px 0;
            color: #777;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            color: #555;
        }
        .sticky-footer {
            text-align: center;
            font-style: italic;
            background-color: #fff; /* Add background color for visibility */
            padding: 10px; /* Add padding for spacing */
        }

        .copyright {
            margin-top: 10px; /* Add margin for spacing */
        }
    </style>
</head>
<body>
    <h1>EVoting Results</h1>
    {{-- Display timestamp within the card --}}
    <p>Exported on: {{ now() }}</p>
    @foreach($votesData as $positionData)
        <div class="card-container">
            <div class="card">
                <h2>{{ $positionData['position'] }}</h2>
                <p>Total Votes: {{ $positionData['total_votes'] }}</p>

                <ul>
                    @foreach($positionData['candidates'] as $candidate)
                        <li>
                            @isset($candidate['candidate'])
                                <strong>Candidate ID:</strong> {{ $candidate['candidate'] }} - <strong>Votes:</strong> {{ $candidate['count'] }}
                            @else
                                <strong>Candidate ID:</strong> N/A - <strong>Votes:</strong> {{ $candidate['count'] }}
                            @endisset
                        </li>
                    @endforeach
                </ul>

                
            </div>
        </div>
    @endforeach
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; EVoting 2023</span>
            </div>
        </div>
    </footer>
</body>
</html>
