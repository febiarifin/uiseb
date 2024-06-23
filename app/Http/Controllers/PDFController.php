<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Abstrak;
use App\Models\Paper;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{

    private $type_abstrak = 'abstrak';
    private $type_paper = 'paper';

    public function print_review($id, $type)
    {
        if ($type == $this->type_abstrak) {
            $abstrak = Abstrak::with(['revisis', 'penulis'])->findOrFail(base64_decode($id));
            $data = [
                'title' => 'Print Review: '. $abstrak->title,
                'type' => $type,
                'logo' => AppHelper::convert_base64('public/manup-master/img/logo_UISEB.png'),
                'abstrak' => $abstrak,
            ];
            $pdf = PDF::loadView('pdf.review', $data);
            return $pdf->stream('REVIEW_'. $abstrak->title. '.pdf');
        }else if($type == $this->type_paper){
            $paper = Paper::with(['revisis','abstrak','videos'])->findOrFail(base64_decode($id));
        }
    }

}
