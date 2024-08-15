<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Abstrak;
use App\Models\Paper;
use App\Models\Registration;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PDFController extends Controller
{

    public function print_review($id)
    {
        $registration = Registration::with(['user', 'category', 'abstraks' => function ($query) {
            $query->with([
                'papers' => function ($query) {
                    $query->with('videos');
                }
            ]);
        }])->findOrFail(base64_decode($id));
        $abstrak = $registration->abstraks()->where('status', Abstrak::ACCEPTED)->first();
        $paper = $abstrak->papers()->where('status', Paper::ACCEPTED)->first();
        $video = $paper->videos()->where('status', Video::ACCEPTED)->first();
        $data = [
            'title' => 'Print Review: '. $abstrak->title,
            'logo' => AppHelper::convert_base64('public/manup-master/img/logo_UISEB.png'),
            'registration' => $registration,
            'abstrak' => $abstrak,
            'paper' => $paper,
            'video' => $video,
        ];
        $pdf = PDF::loadView('pdf.review', $data);
        return $pdf->stream('REVIEW_' . $registration->category->name . '.pdf');
    }

    public function print_symposium($id)
    {
        $registration = Registration::with(['user', 'category', 'abstraks' => function ($query) {
            $query->with([
                'papers' => function ($query) {
                    $query->with('videos');
                }
            ]);
        }])->findOrFail(base64_decode($id));
        $abstrak = $registration->abstraks()->where('status', Abstrak::ACCEPTED)->first();
        $paper = $abstrak->papers()->where('status', Paper::ACCEPTED)->first();
        $video = $paper->videos()->where('status', Video::ACCEPTED)->first();
        $data = [
            'title' => 'Print Symposium: '. $abstrak->title,
            'logo' => AppHelper::convert_base64('public/manup-master/img/logo_UISEB.png'),
            'registration' => $registration,
            'abstrak' => $abstrak,
            'paper' => $paper,
            'video' => $video,
        ];
        $pdf = PDF::loadView('pdf.symposium', $data);
        return $pdf->stream('SYMPOSIUM_' . $registration->category->name . '.pdf');
    }

    public function print_invoice($id)
    {
        $registration = Registration::with(['user', 'category'])->findOrFail(base64_decode($id));
        $data = [
            'title' => 'Print Invoice: '. $registration->category->name,
            'logo' => AppHelper::convert_base64('public/manup-master/img/logo_UISEB.png'),
            'registration' => $registration,
        ];
        $pdf = PDF::loadView('pdf.invoice', $data);
        return $pdf->stream('INVOICE_'.$registration->id. $registration->category->name . '.pdf');
    }

    public function print_loa($id)
    {
        $registration = Registration::with(['user', 'category'])->findOrFail(base64_decode($id));
        $abstrak = $registration->abstraks()->where('status', Abstrak::ACCEPTED)->first();
        // $paper = $abstrak->papers()->where('status', Paper::ACCEPTED)->first();
        $data = [
            'title' => 'Print LOA: '. $registration->category->name,
            'logo' => AppHelper::convert_base64('public/manup-master/img/logo_UISEB.png'),
            'footer_kop' => AppHelper::convert_base64('public/assets/images/footer-kop.png'),
            'registration' => $registration,
            'abstrak' => $abstrak,
            // 'paper' => $paper,
        ];
        $pdf = PDF::loadView('pdf.loa', $data);
        return $pdf->stream('LOA_'.$registration->id. $registration->category->name . '.pdf');
    }

}
