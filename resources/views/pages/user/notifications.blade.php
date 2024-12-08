@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="border border-warning p-2 rounded">
                {!! nl2br('<p>Dear all Participant,</p>
                <p>We cordially invite you to attend the 1st UNSIQ International Symposium on Economics and Business. This prestigious event will be held on December 11 at 07:30 AM via Zoom.</p>
                <p>Please find the details to join the meeting below :&nbsp;<br />Topic: The 1st UNSIQ International Symposium on Economics and Business<br />Date: December 11, 2024<br />Time: 07:30 AM Jakarta Time</p>
                <p>You can join the meeting using the following Zoom link:<br /><a title="Zoom Meeting" href="https://us06web.zoom.us/j/84137000011?pwd=4KsaThwdcRYhoc9ouaCKg2AgZg6N1p.1" target="_blank" rel="noopener">https://us06web.zoom.us/j/84137000011?pwd=4KsaThwdcRYhoc9ouaCKg2AgZg6N1p.1</a></p>
                <p>Meeting ID: 841 3700 0011<br />Passcode: FEBUNSIQ</p>
                <p>To register, please visit :<br /><a title="UISEB Registration" href="https://bit.ly/daftarhadiruiseb24" target="_blank" rel="noopener">https://bit.ly/daftarhadiruiseb24</a></p>
                <p>We look forward to your participation. We sincerely hope you will be able to join us for this important event.</p>
                <p>If you have any questions or require further information, please do not hesitate to contact us :</p>
                <p>08970251067 (Moza)<br />0895632867644 (Regina)</p>
                <p>Best Regards,<br />Committee of UISEB</p>') !!}
            </div>
        </div>
    </div>
@endsection
