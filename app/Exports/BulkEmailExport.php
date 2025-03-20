<?php

namespace App\Exports;

use App\BulkEmail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BulkEmailExport implements FromQuery, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($date, $headings)
    {
        $this->date = $date;
        $this->headings = $headings;
    }
    public function query()
    {
        return BulkEmail::query();
    }

    public function headings() : array
    {
        return $this->headings;
        //return $this->collection()->first()->toArray();
    }

}
