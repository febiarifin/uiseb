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
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <img src="{{ asset('manup-master/img/logo_UISEB.png') }}" alt="UISEB" height="80"class="mb-3">
                    <h4>Receipt :</h4>
                    <div class="flex-grow-1">
                        Name: {{ $registration->user->name }} <br>
                        Email: {{ $registration->user->email }}
                    </div>
                </div>
                <div class="flex-grow-0">
                    <h1 class="text-muted">RECEIPT PAYMENT</h1>
                    @if ($registration->is_valid == \App\Models\Registration::IS_VALID)
                        <h2 class="text-success">PAID</h2>
                    @else
                        <h2 class="text-danger">UNPAID</h2>
                    @endif
                    <div class="mt-4">
                        Payment Date: {{ \App\Helpers\AppHelper::parse_date_short($registration->acc_at) }}
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="bg-danger text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item Description</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $registration->category->name }}
                            @if ($registration->category->is_paper)
                                <span class="badge badge-secondary">+ PAPER</span>
                            @endif
                        </td>
                        <td>{{ \App\Helpers\AppHelper::currency($registration->category->amount) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>AMOUNT TOTAL</b></td>
                        <td>{{ \App\Helpers\AppHelper::currency($registration->category->amount) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3">
                <button type="button" class="btn btn-primary" id="printReceiptBtn"><i class="fas fa-print"></i> PRINT
                    RECEIPT</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#printReceiptBtn').click(function() {
                window.print();
            });
        });
    </script>
@endsection
