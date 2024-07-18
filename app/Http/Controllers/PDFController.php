<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Abstrak;
use App\Models\Registration;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{

    public function print_review($id)
    {
        $registration = Registration::with(['category', 'abstraks' => function ($query) {
            $query->with([
                'papers' => function ($query) {
                    $query->with('videos');
                }
            ]);
        }])->findOrFail(base64_decode($id));
        $data = [
            'title' => 'Print Review: ',
            'logo' => AppHelper::convert_base64('public/manup-master/img/logo_UISEB.png'),
            'registration' => $registration,
            'abstrak' => $registration->abstraks()->where('status', Abstrak::ACCEPTED)->first(),
        ];
        $pdf = PDF::loadView('pdf.review', $data);
        return $pdf->stream('REVIEW_' . $registration->category->name . '.pdf');
    }
}
