@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
    </div>

    <div class="row col-12">
        @foreach ($categories as $category)
            <div class="col-md-5 card shadow mb-3 mr-3">
                <div class="card-body">
                    <h5>{{ $category->name }}
                        @if ($category->is_paper)
                            <span class="badge badge-secondary">+ PAPER</span>
                        @endif
                    </h5>
                    <p class="text-muted">{{ $category->description }}</p>
                    <h5 class="text-muted">{{ \App\Helpers\AppHelper::currency($category) }}</h5>
                </div>
                <div class="card-footer">
                    <a href="{{ route('registration.create', $category->id) }}" class="btn btn-primary btn-sm"
                        onclick="this.innerHTML = 'REGISTERED'; this.classList.add('disabled'); this.disabled = true;"><i
                            class="fas fa-plus"></i> REGISTER</a>
                </div>
            </div>
        @endforeach
        <div class="col-12 mt-3">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
