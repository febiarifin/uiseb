@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-grow-1">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <div class="flex-shrink-0">
                @if ($video->status == \App\Models\Abstrak::REVISI_MINOR)
                    <span class="badge badge-warning">REVISI MINOR</span>
                @elseif ($video->status == \App\Models\Abstrak::REVISI_MAYOR)
                    <span class="badge badge-warning">REVISI MAYOR</span>
                @elseif ($video->status == \App\Models\Abstrak::REJECTED)
                    <span class="badge badge-danger">REJECTED</span>
                @elseif ($video->status == \App\Models\Abstrak::ACCEPTED)
                    <span class="badge badge-success">ACCEPTED</span>
                @elseif ($video->status == \App\Models\Abstrak::REVIEW)
                    <span class="badge badge-secondary">REVIEW</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" class="form-control" value="{{ $video->paper->abstrak->title }}" name="title"
                    disabled>
            </div>
            <div class="mb-3">
                <label>Author</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Depan</th>
                        <th>Nama Tengah</th>
                        <th>Nama Belakang</th>
                        <th>Email</th>
                        <th>Afiliasi</th>
                        <th>Degree</th>
                        <th>Address</th>
                        <th>Research Interest</th>
                        <th>Coresponding</th>
                    </tr>
                    @foreach ($video->paper->abstrak->penulis as $author)
                        <tr>
                            <td>{{ $author->first_name }}</td>
                            <td>{{ $author->middle_name }}</td>
                            <td>{{ $author->last_name }}</td>
                            <td>{{ $author->email }}</td>
                            <td>{{ $author->affiliate }}</td>
                            <td>{{ $author->degree }}</td>
                            <td>{{ $author->address }}</td>
                            <td>{{ $author->research_interest }}</td>
                            <td>
                                @if ($author->coresponding)
                                    <span class="badge badge-light"><i class="fas fa-check-circle"></i> Sebagai
                                        Coresponding</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @if ($video->acc_at)
                <div class="mb-3">
                    <label><i class="fas fa-calendar"></i> Accepted At</label>
                    <b class="text-success">{{ \App\Helpers\AppHelper::parse_date_short($video->acc_at) }}</b>
                </div>
            @endif
            <div class="mb-3">
                <label>Video:
                    @if ($video->link)
                        <a href="{{ asset($video->link) }}" target="_blank"><i class="fab fa-youtube"></i>
                            View Video</a>
                    @endif
                </label>
            </div>
            @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                <div class="mt-4">
                    @if ($video->status == \App\Models\Video::REVIEW)
                        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#reviewModal">
                            <i class="fas fa-edit"></i> Review Video
                        </a>
                    @endif
                    <!-- Revisi Video Modal-->
                    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Review Video</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('videos.review.store', $video->id) }}" method="post" id="reviewForm">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Catatan</label>
                                            <input id="note" type="hidden" name="note" required>
                                            <trix-editor input="note"></trix-editor>
                                            @error('note')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="">--pilih--</option>
                                                <option value="{{ \App\Models\Video::REVISI_MINOR }}">REVISI MINOR
                                                </option>
                                                <option value="{{ \App\Models\Video::REVISI_MAYOR }}">REVISI MAYOR
                                                </option>
                                                <option value="{{ \App\Models\Video::REJECTED }}">REJECTED</option>
                                                <option value="{{ \App\Models\Video::ACCEPTED }}">ACCEPTED</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit" id="submitButton">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            Revisi <span class="badge badge-danger">{{ count($revisis) }}</span>
        </div>
        <div class="card-body">
            @foreach ($revisis as $revisi)
                <div class="border shadow rounded p-2 mb-2 border-secondary">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <small class="text-muted">{{ \App\Helpers\AppHelper::parse_date($revisi->created_at) }}</small>
                        </div>
                        <div class="flex-shrink-0">
                            <small class="text-muted">Reviewed by <b>{{ $revisi->user->name }}</b></small>
                        </div>
                    </div>
                    {!! nl2br($revisi->note) !!}
                    <br>
                    <small>Video Link: <a href="{{ $revisi->link }}" target="_blank"><i class="fab fa-youtube"></i> View Video</a></small>
                </div>
            @endforeach
            <div class="mt-4">
                {{ $revisis->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojsyoutube/2.6.1/Youtube.min.js"></script> --}}
    <script>
        // var player = videojs('my-video');

        document.getElementById('reviewForm').addEventListener('submit', function() {
            var submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Processing...';
        });
    </script>
@endsection
