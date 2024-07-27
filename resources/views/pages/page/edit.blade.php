@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-grow-1">
                <a href="{{ route('pages.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('pages.show', $page->id) }}" target="_blank">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Halaman {{ $page->name }} <i
                            class="fas fa-globe"></i></h6>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('pages.update', $page->id) }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" value="{{ $page->name }}" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal</label>
                        <input type="datetime-local" class="form-control" value="{{ $page->date }}" name="date"
                            required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Tagline</label>
                        <input type="text" class="form-control" value="{{ $page->theme }}" name="theme" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Tentang Atas</label>
                        <input id="about_1" type="hidden" name="about_1" value="{{ $page->about_1 }}" required>
                        <trix-editor input="about_1"></trix-editor>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Tentang Bawah</label>
                        <input id="about_2" type="hidden" name="about_2" value="{{ $page->about_2 }}" required>
                        <trix-editor input="about_2"></trix-editor>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Scope</label>
                        <input id="scope" type="hidden" name="scope" value="{{ $page->scope }}" required>
                        <trix-editor input="scope"></trix-editor>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Submission</label>
                        <input id="submission" type="hidden" name="submission" value="{{ $page->submission }}" required>
                        <trix-editor input="submission"></trix-editor>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Image Background</label>
                        <input type="file" class="form-control @error('image_1') is-invalid @enderror" name="image_1"
                            accept=".png,.jpeg,.jpg">
                        @error('image_1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($page->image_1)
                            <img src="{{ asset($page->image_1) }}" height="100" class="mt-2">
                        @endif
                    </div>
                    <div class="col-md-4
                            mb-3">
                        <label>Image About Atas</label>
                        <input type="file" class="form-control @error('image_2') is-invalid @enderror" name="image_2"
                            accept=".png,.jpeg,.jpg">
                        @error('image_2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($page->image_2)
                            <img src="{{ asset($page->image_2) }}" height="100" class="mt-2">
                        @endif
                    </div>
                    <div class="col-md-4
                            mb-3">
                        <label>Image About Bawah</label>
                        <input type="file" class="form-control @error('image_3') is-invalid @enderror" name="image_3"
                            accept=".png,.jpeg,.jpg">
                        @error('image_3')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($page->image_3)
                            <img src="{{ asset($page->image_3) }}" height="100" class="mt-2">
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Timeline</h6>
            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#timelineModal">
                <i class="fas fa-plus-circle"></i> Buat Timeline
            </a>
        </div>
        <div class="card-body">
            @if (count($page->timelines) == 0)
                Tidak ada timeline
            @else
                <ul class="timeline">
                    @foreach ($page->timelines as $timeline)
                        <li>
                            <span class="text-primary">{{ $timeline->name }}</span>
                            <span
                                class="float-right text-primary">{{ \App\Helpers\AppHelper::parse_date_timeline($timeline->date) }}
                                @if ($timeline->date_end)
                                    - {{ \App\Helpers\AppHelper::parse_date_timeline($timeline->date_end) }}
                                @endif
                            </span>
                            <p class="text-justify">{{ $timeline->description }}</p>
                            <form action="{{ route('timelines.destroy', $timeline->id) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin dihapus?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Speaker</h6>
            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#speakerModal">
                <i class="fas fa-plus-circle"></i> Tambah Speaker
            </a>
        </div>
        <div class="card-body row">
            @if (count($page->speakers) == 0)
                Tidak ada speaker
            @else
                @foreach ($page->speakers as $speaker)
                    <div class="col-md-3 text-center border rounded p-2 shadow">
                        @if ($speaker->image)
                            <img src="{{ asset($speaker->image) }}" height="100"> <br>
                        @endif
                        <span>{{ $speaker->name }}</span>
                        <br>
                        <span>{{ $speaker->institution }}</span>
                        <br>
                        <span>{{ $speaker->is_keynote ? 'KEYNOTE SPEAKER' : 'INVITED SPEAKER' }}</span>
                        <form action="{{ route('speakers.destroy', $speaker->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin dihapus?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="row">
        <div class="card shadow mb-4 col-md-6">
            <div class="card-header d-flex">
                <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Artikel</h6>
                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#articleModal">
                    <i class="fas fa-plus-circle"></i> Tambah Link Artikel
                </a>
            </div>
            <div class="card-body row">
                @if (count($page->articles) == 0)
                    Tidak ada link artikel
                @else
                    @foreach ($page->articles as $article)
                        <a href="{{ $article->link }}" class="btn btn-secondary rounded-pill"
                            target="_blank">{{ $article->name }} <i class="fas fa-paperclip"></i></a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin dihapus?')"><i class="fas fa-trash"></i></button>
                        </form>
                        &nbsp;
                    @endforeach
                @endif
            </div>
        </div>

        <div class="card shadow mb-4 col-md-6">
            <div class="card-header d-flex">
                <h6 class="m-0 font-weight-bold text-primary flex-grow-1">Kontak</h6>
                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#contactModal">
                    <i class="fas fa-plus-circle"></i> Tambah Kontak
                </a>
            </div>
            <div class="card-body row">
                @if (count($page->contacts) == 0)
                    Tidak ada kontak
                @else
                    @foreach ($page->contacts as $contact)
                        <a href="https://api.whatsapp.com/send?phone={{ $contact->phone_number }}"
                            class="btn btn-secondary rounded-pill" target="_blank">{{ $contact->phone_number }}
                            ({{ $contact->name }}) <i class="fab fa-whatsapp"></i></a>
                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin dihapus?')"><i class="fas fa-trash"></i></button>
                        </form>
                        &nbsp;
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Timeline Modal-->
    <div class="modal fade" id="timelineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Timeline</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('timelines.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Berakhir (Opsional)</label>
                            <input type="date" class="form-control" name="date_end">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Speaker Modal-->
    <div class="modal fade" id="speakerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Speaker</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('speakers.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label>Institusi</label>
                            <input type="text" class="form-control" name="institution" required>
                        </div>
                        <div class="mb-3">
                            <label>Foto</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="is_keynote" class="form-control" required>
                                <option value="">--pilih--</option>
                                <option value="1">KEYNOTE SPEAKER</option>
                                <option value="0">INVITE SPEAKER</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Article Modal-->
    <div class="modal fade" id="articleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Link Artikel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label>Link</label>
                            <input type="url" class="form-control" name="link" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Contact Modal-->
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kontak</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('contacts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Kontak</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label>Nomor WhatsApp (Awali dengan <b>62</b>)</label>
                            <input type="text" class="form-control" name="phone_number" placeholder="62..." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
