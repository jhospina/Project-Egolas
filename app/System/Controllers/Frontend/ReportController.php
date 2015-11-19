<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\System\Models\Report;
use Illuminate\Http\Request;
use App\System\Models\User;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Complements\UI;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\Util;

class ReportController extends Controller {

    //Reportar un problema (/report/problem)
    function getReportProblem() {
        $types = Report::getTypes();
        return view("frontend/contents/report/problem")->with("types", $types);
    }

    //Recibe un reporte de problema por parte del usuario
    function postReportProblem(Request $request) {

        $extensions = array("png", "jpg", "jpeg");

        $data = $request->all();

        if (!isset($data[Report::ATTR_TYPE]) || !isset($data[Report::ATTR_DESCRIPTION]))
            return redirect()->back();

        $report = new Report;
        $report->user_id = Auth::user()->id;
        $report->type = $data[Report::ATTR_TYPE];
        $report->date = DateUtil::getCurrentTime();
        $report->description = Util::trimText(strip_tags($data[Report::ATTR_DESCRIPTION]), 500);
        $report->image = null;

        if ($request->hasFile(Report::ATTR_IMAGE)) {
            $image = $request->file(Report::ATTR_IMAGE);
            $extension = strtolower($image->getClientOriginalExtension());
            //Valida la extension del archivo
            if (!in_array($extension, $extensions))
                return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Extension de archivo no permitida, no es una imagen valida."));

            //Valida el tamaño del archivo
            if ($image->getSize() > 2000000)
                return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Tamaño del archivo excesivo. Maximo 2MB"));

            //Almacena la imagen subida por el usuario en la carpeta temporal
            $filename = DateUtil::getTimeStamp() . "." . $extension;
            $image->move(Auth::user()->getPathUploads(), $filename);
            $report->image = url(Auth::user()->getPathUploads() . $filename);
        }

        $report->save();


        return redirect("browser")->with(UI::modalMessage("¡Gracias por tu reporte!", "Tus comentarios acerca de tu experencia ayudan a mejorar la plataforma de Bandicot. Nos pondremos en contacto contigo por correo electrónico si necesitamos saber más detalles del problema.", "Cerrar"));
    }

}
