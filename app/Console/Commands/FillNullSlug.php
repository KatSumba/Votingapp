<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FillNullSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:nullslug {table}';
    protected $description = 'Fill null slugs for specified table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $table = $this->argument('table');

        if (!in_array($table, ['applications', 'positions'])) {
            $this->error('Invalid table name. Supported tables: applications, positions');
            return;
        }

        $records = DB::table($table)->whereNull('slug')->get();

        foreach ($records as $record) {
            $random_string = Str::random(10);

            // Check if the generated slug is unique
            while (DB::table($table)->where('slug', $random_string)->exists()) {
                $random_string = Str::random(10);
            }

            DB::table($table)->where('id', $record->id)->update(['slug' => $random_string]);
        }

        $this->info("Null slugs filled successfully for the '$table' table.");
    }
}
