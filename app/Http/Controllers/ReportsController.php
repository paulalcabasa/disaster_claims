<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TravisRSExport;
use App\Exports\TravizPulloutExport;
use Maatwebsite\Excel\Facades\Excel;
class ReportsController extends Controller
{
    public function exportTravisRs(Request $request)
    {
        return Excel::download(new TravisRSExport(), 'travis_rs.xlsx');
    }

    public function exportTravizPullout(Request $request)
    {
        return Excel::download(new TravizPulloutExport(), 'traviz_pullout.xlsx');
    }
}
