@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-grow-1">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                Template paper <a href=""><I class="fas fa-download"></I> DOWNLOAD</a>
            </div>
            <form action="{{ route('papers.update', $paper->id) }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label>Judul Abstrak</label>
                    <input type="text" class="form-control" value="{{ $paper->abstrak->title }}" name="title" disabled>
                </div>
                <div class="mb-3">
                    <label>Author</label>
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Depan</th>
                            <th>Nama Belakang</th>
                            <th>Email</th>
                            <th>Afiliasi</th>
                            <th>Coresponding</th>
                        </tr>
                        @foreach ($paper->abstrak->penulis as $author)
                            <tr>
                                <td>{{ $author->first_name }}</td>
                                <td>{{ $author->last_name }}</td>
                                <td>{{ $author->email }}</td>
                                <td>{{ $author->affiliate }}</td>
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
                <div class="col-md-12 mb-3">
                    <label>Abstrak</label>
                    <input id="abstract" type="hidden" name="abstract" value="{{ $paper->abstract }}" required>
                    <trix-editor input="abstract"></trix-editor>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Daftar Pustaka</label>
                    <input id="bibliography" type="hidden" name="bibliography" value="{{ $paper->bibliography }}" required>
                    <trix-editor input="bibliography"></trix-editor>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Keyword</label>
                    <br>
                    <input type="text" class="form-control" data-role="tagsinput" name="keyword" value="{{ $paper->keyword }}" required>
                    <br>
                    <small>Enter jika ingin menginputan lebih dari satu.</small>
                </div>
                <div class="mb-3">
                    <label>File (Format: <b>.docx</b>)</label>
                    <input type="file" class="form-control" name="file" accept=".docx" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script>
        $(function() {
            $('input')
                .on('change', function(event) {
                    var $element = $(event.target);
                    var $container = $element.closest('.example');

                    if (!$element.data('tagsinput')) return;

                    var val = $element.val();
                    if (val === null) val = 'null';
                    var items = $element.tagsinput('items');

                    $('code', $('pre.val', $container)).html(
                        $.isArray(val) ?
                        JSON.stringify(val) :
                        '"' + val.replace('"', '\\"') + '"'
                    );
                    $('code', $('pre.items', $container)).html(
                        JSON.stringify($element.tagsinput('items'))
                    );
                })
                .trigger('change');
        });
    </script>
@endsection
