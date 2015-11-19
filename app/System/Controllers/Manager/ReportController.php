<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Models\Report;

class ReportController extends Controller {

    function getReports() {
        $reports = Report::orderBy("id", "DESC")->paginate(30);
        return view("manager/contents/report/index")->with("reports", $reports);
    }

}
