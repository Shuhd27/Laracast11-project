<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model {
    use HasFactory;
    
    protected $table = 'job_listings';

    // a way to use for the jobs/create
    protected $guarded = ['employer_id', 'title', 'salary'];

    // a simple way to use for jobs/create
    protected $guarded = [];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listings_id");
    }
}
// $jobs->$tag