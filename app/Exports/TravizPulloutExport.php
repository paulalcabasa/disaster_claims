<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Report;

class TravizPulloutExport implements FromView
{

    public function __construct(){} 
    
    public function view(): View {
        $report = new Report;

        $data = $report->getPulloutTraviz();

        return view('reports.traviz_pullout', [
            'data' => $data
        ]);
    }
}
