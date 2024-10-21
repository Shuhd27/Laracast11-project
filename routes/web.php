<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Job;


Route::get('/', function () {
    return view('home');
});

// Index
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', [ 
        'jobs' => $jobs
    ]);
});

// Create
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// A page to show a job
Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

// store
Route::post('/jobs', function() {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');
});

// Edit
Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

// Update
Route::patch('/jobs/{id}', function ($id) {
    // validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    // authorize (on hold....)
    // update the job
    $job = Job::findOrFail($id); // null

    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);
    // Andere manier om de job te updaten
/*
    $job->title = request('title');
    $job->salary = request('salary');
    $job->save();
*/
    // redirect to the job page
    return redirect('/jobs/' . $job->id);
});

// Destory
Route::delete('/jobs/{id}', function ($id) {
    // Authorize (on hold....)
    
    // Delete
    Job::findOrFail($id)->delete();

    // Redirect
    return redirect('/jobs');

});

Route::get('/contact', function () {
    return view('contact');
});

/*
// een ander manier om de job te verwijderen maar de manier die ik heb gebruikt is wat makkelijker!
// ik schrijf het hier gwn zodat ik het niet vergeet that's it.
$job = Job::findOrFail($id);
    $job->delete()

*/


/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
*/