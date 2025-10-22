<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING JOBS TABLE ===\n\n";

$jobs = DB::table('jobs')->get();

echo "Total jobs in database: " . $jobs->count() . "\n\n";

foreach ($jobs as $job) {
    echo "ID: {$job->id}\n";
    echo "Title: " . ($job->vacancy_title ?? $job->title) . "\n";
    echo "Code: {$job->code}\n";
    echo "Status: {$job->status}\n";
    echo "End Date: " . ($job->end_date ?? $job->closing_at ?? 'null') . "\n";
    echo "Education: " . ($job->education_level ?? 'null') . "\n";
    echo "Function: " . ($job->function ?? $job->department ?? 'null') . "\n";
    echo "Total Needed: " . ($job->total_needed ?? 'null') . "\n";
    echo "Created At: {$job->created_at}\n";
    echo "---\n\n";
}

echo "\n=== JOBS WITH STATUS 'open' ===\n\n";

$openJobs = DB::table('jobs')->where('status', 'open')->get();
echo "Open jobs: " . $openJobs->count() . "\n\n";

foreach ($openJobs as $job) {
    $title = $job->vacancy_title ?? $job->title;
    $deadline = $job->end_date ?? $job->closing_at ?? 'No deadline';
    echo "- {$title} ({$job->code}) - Deadline: {$deadline}\n";
}

echo "\n=== JOBS WITH STATUS 'draft' ===\n\n";

$draftJobs = DB::table('jobs')->where('status', 'draft')->get();
echo "Draft jobs: " . $draftJobs->count() . "\n\n";

foreach ($draftJobs as $job) {
    $title = $job->vacancy_title ?? $job->title;
    echo "- {$title} ({$job->code})\n";
}

echo "\n=== PUBLIC JOBS QUERY (status=open AND end_date>=today) ===\n\n";

$publicJobs = DB::table('jobs')
    ->where('status', 'open')
    ->where(function($query) {
        $query->where('end_date', '>=', date('Y-m-d'))
              ->orWhere('closing_at', '>=', now())
              ->orWhereNull('end_date');
    })
    ->get();
    
echo "Public jobs: " . $publicJobs->count() . "\n\n";

foreach ($publicJobs as $job) {
    $title = $job->vacancy_title ?? $job->title;
    $deadline = $job->end_date ?? $job->closing_at ?? 'Open';
    echo "- {$title} ({$job->code}) - Deadline: {$deadline}\n";
}
