<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Report;

class TravisRSExport implements FromView
{

    public function __construct(){
    } 
    
    public function view(): View {
        $report = new Report;

        $data = $report->getRsTravis();

        return view('reports.travis_rs', [
            'data' => $data
        ]);
    }
}
