@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('user.update.profile', $user->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" name="name" required>
                </div>
                @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA || Auth::user()->type == \App\Models\User::TYPE_REVIEWER || Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                    <div class="mb-3">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" value="{{ $user->phone_number }}" name="phone_number"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Institution</label>
                        <input type="text" class="form-control" value="{{ $user->institution }}" name="institution"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Position</label>
                        <select name="position" class="form-control" required>
                            <option value="">--pilih--</option>
                            <option value="Lecturer" {{ $user->position == 'Lecturer' ? 'selected' : null }}>Lecturer</option>
                            <option value="Researcher" {{ $user->position == 'Researcher' ? 'selected' : null }}>Researcher</option>
                            <option value="Teacher" {{ $user->position == 'Teacher' ? 'selected' : null }}>Teacher</option>
                            <option value="Student" {{ $user->position == 'Student' ? 'selected' : null }}>Student</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Subject Backgorund</label>
                        <select name="subject_background" class="form-control" required>
                            <option value="">--pilih--</option>
                            <option value="Pharmacy" {{ $user->subject_background == 'Pharmacy' ? 'selected' : null }}>Pharmacy</option>
                            <option value="Chemistry" {{ $user->subject_background == 'Chemistry' ? 'selected' : null }}>Chemistry</option>
                            <option value="Statistics" {{ $user->subject_background == 'Statistics' ? 'selected' : null }}>Statistics</option>
                            <option value="Engineering, etc." {{ $user->subject_background == 'Engineering, etc.' ? 'selected' : null }}>Engineering, etc.</option>
                        </select>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Update Password</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('user.update.password', $user->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <label>Old Password</label>
                    <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                        name="old_password" required>
                    @error('old_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required>
                    <div class="invalid-feedback" id="confirmPasswordFeedback">
                        Konfirmasi password tidak cocok dengan password baru.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3" id="submitButton" disabled><i class="fas fa-check"></i>
                    SIMPAN</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const confirmPasswordFeedback = document.getElementById('confirmPasswordFeedback');
        const submitButton = document.getElementById('submitButton');

        confirmPasswordInput.addEventListener('input', () => {
            if (confirmPasswordInput.value === passwordInput.value) {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordFeedback.style.display = 'none';
                submitButton.removeAttribute('disabled');
            } else {
                confirmPasswordInput.classList.add('is-invalid');
                confirmPasswordFeedback.style.display = 'block';
                submitButton.setAttribute('disabled', 'disabled');
            }
        });

        passwordInput.addEventListener('input', () => {
            confirmPasswordInput.dispatchEvent(new Event('input'));
        });

        submitButton.addEventListener('click', () => {
            confirmPasswordInput.classList.remove('is-invalid');
            confirmPasswordFeedback.style.display = 'none';
        });
    </script>
@endsection
