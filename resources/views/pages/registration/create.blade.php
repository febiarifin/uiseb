@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ route('registration.list') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('registration.store') }}" method="post">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <div class="col-md-12 card shadow mb-3">
                    <div class="card-body">
                        <h5>{{ $category->name }}
                            @if ($category->is_paper)
                                <span class="badge badge-secondary">+ PAPER</span>
                            @endif
                        </h5>
                        <p class="text-muted">{{ $category->description }}</p>
                        <h5 class="text-muted">{{ \App\Helpers\AppHelper::currency($category) }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" value="{{ $user->phone_number }}" disabled>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Institution</label>
                        <input type="text" class="form-control" value="{{ $user->institution }}" disabled>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Position</label>
                        <input type="text" class="form-control" value="{{ $user->position }}" disabled>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Subject Background</label>
                        <input type="text" class="form-control" value="{{ $user->subject_background }}" disabled>
                    </div>
                </div>
                <a class="btn btn-primary mt-3" href="#" data-toggle="modal" data-target="#confirmModal"><i
                        class="fas fa-check"></i> CONFIRM
                    REGISTRATION</a>

                <!-- Confirm Modal-->
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi
                                    Registration</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Sure you want to confirm registration?</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>
                                    YES</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
