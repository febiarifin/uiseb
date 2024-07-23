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
                Template abstrak <a href=""><I class="fas fa-download"></I> DOWNLOAD</a>
            </div>
            <form action="{{ route('abstraks.update', $abstrak->id) }}" method="post" enctype="multipart/form-data"
                id="dynamicForm" onsubmit="updateCheckboxes()">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label>Jenis Paper</label>
                    <select name="type_paper" class="form-control" required>
                        <option value="">--pilih--</option>
                        <option value="Literature review"
                            {{ $abstrak->type_paper == 'Literature review' ? 'selected' : null }}>Literature review</option>
                        <option value="Original research paper"
                            {{ $abstrak->type_paper == 'Original research paper' ? 'selected' : null }}>Original research
                            paper</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Judul (Min: 20 Words)</label>
                    <input type="text" class="form-control" value="{{ $abstrak->title }}" name="title" required>
                </div>
                <div class="row form-set border border-secondary rounded m-1 mb-3">
                    @if (count($abstrak->penulis) != 0)
                        @foreach ($abstrak->penulis as $author)
                            <div class="col-md-4 mb-3">
                                <label>Nama Depan</label>
                                <input type="text" class="form-control" value="{{ $author->first_name }}" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Nama Tengah</label>
                                <input type="text" class="form-control" value="{{ $author->middle_name }}" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Nama Belakang</label>
                                <input type="text" class="form-control" value="{{ $author->last_name }}" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $author->email }}" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Afiliasi</label>
                                <input type="text" class="form-control" value="{{ $author->affiliate }}" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Degree</label>
                                <input type="text" class="form-control" value="{{ $author->degree }}" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Address</label>
                                <input type="text" class="form-control" value="{{ $author->address }}" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Research Interest</label>
                                <input type="text" class="form-control" value="{{ $author->research_interest }}"
                                    disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Coresponding</label>
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="checkbox"
                                        {{ $author->coresponding ? 'checked' : null }} @disabled(true)>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-4 mb-3">
                            <label>Nama Depan</label>
                            <input type="text" class="form-control" name="first_names[]" value="{{ $user->first_name }}"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Nama Tengah</label>
                            <input type="text" class="form-control" name="middle_names[]"
                                value="{{ $user->middle_name }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Nama Belakang</label>
                            <input type="text" class="form-control" name="last_names[]" value="{{ $user->last_name }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" name="emails[]" value="{{ $user->email }}"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Afiliasi</label>
                            <input type="text" class="form-control" name="affiliates[]" value="{{ $user->institution }}"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Degree</label>
                            <select name="degrees[]" class="form-control" required>
                                <option value="">--pilih--</option>
                                <option value="Associate degree">Associate degree</option>
                                <option value="Bachelor’s degree">Bachelor’s degree</option>
                                <option value="Master’s degree">Master’s degree</option>
                                <option value="Doctoral degree">Doctoral degree</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address[]" value="{{ $user->address }}"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Research Interest</label>
                            <input type="text" class="form-control" name="research_interests[]"
                                value="{{ $user->research_interest }}" required>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label>Coresponding</label>
                            <div class="form-check mt-1">
                                <input class="form-check-input coresponding-checkbox" type="checkbox" value="1"
                                    name="coresponding_checkboxes[]" onchange="updateCheckboxValue(this)">
                                <input type="hidden" class="coresponding-hidden" name="corespondings[]" value="0">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger mt-4 ml-3 removeButton"><i class="fas fa-trash"></i></button>
                        </div>
                        <hr>
                    @endif
                </div>
                @if ($abstrak->status == null)
                    <div class="mb-4">
                        <button class="btn btn-secondary btn-sm" id="addButton"><i class="fas fa-plus-circle"></i> Add
                            Author</button>
                    </div>
                @endif
                <div class="col-md-12 mb-3">
                    <label>Abstrak (Min: 250 Words)</label>
                    <input id="abstract" type="hidden" name="abstract" value="{{ $abstrak->abstract }}" required>
                    <trix-editor input="abstract"></trix-editor>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Keyword</label>
                    <br>
                    <input type="text" class="form-control" data-role="tagsinput" name="keyword"
                        value="{{ $abstrak->keyword }}" required>
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
        document.getElementById('addButton').addEventListener('click', function() {
            var formSet = document.querySelector('.form-set');
            var clone = formSet.cloneNode(true);
            clone.querySelectorAll('input').forEach(function(input) {
                if (input.type === 'text') {
                    input.value = '';
                } else if (input.type === 'checkbox') {
                    input.checked = false;
                    input.value = '1';
                } else if (input.type === 'hidden') {
                    input.value = '0';
                }
            });
            clone.querySelectorAll('.removeButton').forEach(function(button) {
                button.addEventListener('click', removeFields);
            });
            document.getElementById('dynamicForm').insertBefore(clone, this.parentNode);
        });

        function removeFields(event) {
            var formSet = event.target.closest('.form-set');
            if (document.querySelectorAll('.form-set').length > 1) {
                formSet.remove();
            }
        }

        function updateCheckboxValue(checkbox) {
            var hiddenInput = checkbox.closest('.form-check').querySelector('.coresponding-hidden');
            hiddenInput.value = checkbox.checked ? '1' : '0';
        }

        function updateCheckboxes() {
            document.querySelectorAll('.coresponding-checkbox').forEach(function(checkbox) {
                var hiddenInput = checkbox.closest('.form-check').querySelector('.coresponding-hidden');
                hiddenInput.value = checkbox.checked ? '1' : '0';
            });
        }

        document.querySelectorAll('.removeButton').forEach(function(button) {
            button.addEventListener('click', removeFields);
        });

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
