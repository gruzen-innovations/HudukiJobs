<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SubjectPdf extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'subject_pdf';

    protected $fillable = [
    ];
}
