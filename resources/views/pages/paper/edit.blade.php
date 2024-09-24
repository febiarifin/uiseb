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
                <i class="fas fa-info-circle"></i> You can see the paper template at the following link <a
                    href="{{ asset($setting->template_full_paper) }}" target="_blank"><i class="fas fa-download"></i> Paper
                    Template</a>
            </div>
            <form action="{{ route('papers.update', $paper->id) }}" method="post" enctype="multipart/form-data" onsubmit=" this.querySelector('button[type=submit]').disabled = true;">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label>Abstract Title</label>
                    <input type="text" class="form-control" value="{{ $paper->abstrak->title }}" name="title" disabled>
                </div>
                <div class="mb-3">
                    <label>Author</label>
                    <table class="table table-bordered">
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Afiliasi</th>
                            <th>Degree</th>
                            <th>Address</th>
                            <th>Research Interest</th>
                            <th>Coresponding</th>
                        </tr>
                        @foreach ($paper->abstrak->penulis as $author)
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
                <div class="col-md-12 mb-3">
                    <label>Abstract</label>
                    {{-- <input id="abstract" type="hidden" name="abstract" value="{{ $paper->abstrak->abstract }}" required>
                    <trix-editor input="abstract"></trix-editor> --}}
                    <div class="p-2 border border-secondary rounded">
                        {!! nl2br($paper->abstrak->abstract) !!}
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Bibliography</label>
                    <input id="bibliography" type="hidden" name="bibliography" value="{{ $paper->bibliography }}"
                        required>
                    <trix-editor input="bibliography"></trix-editor>
                    @error('bibliography')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label>Keyword</label>
                    <br>
                    <input type="text" class="form-control" data-role="tagsinput" name="keyword"
                        value="{{ $paper->abstrak->keyword }}" required>
                    <br>
                    <small>Press enter after 1 keyword</small>
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
