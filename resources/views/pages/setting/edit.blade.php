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
            <form action="{{ route('settings.update', $setting->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label>Informasi Pembayaran</label>
                    <input id="information" type="hidden" name="information" value="{{ $setting->information }}">
                    <trix-editor input="information"></trix-editor>
                </div>
                <div class="mb-3">
                    <label>Template Video</label>
                    <input type="url" name="template_video" class="form-control" value="{{ $setting->template_video }}">
                </div>
                <div class="mb-3">
                    <label>Template Abstract</label>
                    <input type="file" name="template_abstract" class="form-control @error('template_abstract')  @enderror" accept=".docx"
                        @if (!$setting->template_abstract)  @endif>
                    @if ($setting->template_abstract)
                        <a href="{{ asset($setting->template_abstract) }}"><i class="fas fa-download"></i> Download</a>
                    @endif
                    @error('template_abstract')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Template Full Paper</label>
                    <input type="file" name="template_full_paper" class="form-control" accept=".docx"
                        @if (!$setting->template_full_paper)  @endif>
                    @if ($setting->template_full_paper)
                        <a href="{{ asset($setting->template_full_paper) }}"><i class="fas fa-download"></i> Download</a>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Confirmation Letter</label>
                    <input type="file" name="confirmation_letter" class="form-control" accept=".docx"
                        @if (!$setting->confirmation_letter)  @endif>
                    @if ($setting->confirmation_letter)
                        <a href="{{ asset($setting->confirmation_letter) }}"><i class="fas fa-download"></i> Download</a>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Copyright Letter</label>
                    <input type="file" name="copyright_letter" class="form-control" accept=".docx"
                        @if (!$setting->copyright_letter)  @endif>
                    @if ($setting->copyright_letter)
                        <a href="{{ asset($setting->copyright_letter) }}"><i class="fas fa-download"></i> Download</a>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Self Declare Letter</label>
                    <input type="file" name="self_declare_letter" class="form-control" accept=".docx"
                        @if (!$setting->self_declare_letter)  @endif>
                    @if ($setting->self_declare_letter)
                        <a href="{{ asset($setting->self_declare_letter) }}"><i class="fas fa-download"></i> Download</a>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Flayer</label>
                    <input type="file" name="flayer" class="form-control" accept=".pdf"
                        @if (!$setting->flayer)  @endif>
                    @if ($setting->flayer)
                        <a href="{{ asset($setting->flayer) }}"><i class="fas fa-download"></i> Download</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
