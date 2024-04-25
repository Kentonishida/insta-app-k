@extends('layouts.app')
@section('title', $user->name)
@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update')}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <h2 class="h3 mb-3 fw-light text-muted">Update Profile</h2>
                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="#" alt="{{ $user->name }}" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg avater-lg">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1" aria-describedby="avatar-info">
                        <div class="form-text" id="avatar-info">
                            Acceptable formats are: jpeg, jpg,png, gif only. <br>
                            Max file size is 1048Kb.
                        </div>
                        {{-- Error message area --}}
                        @error('avatar')
                          <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" autofocus>
                    {{-- Error message area --}}
                    @error('name')
                          <p class="text-danger small">{{ $message }}</p>
                        @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                    {{-- Error message area --}}
                    @error('email')
                          <p class="text-danger small">{{ $message }}</p>
                        @enderror
                </div>
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{ old('introduction', $user->introduction) }}</textarea>
                    {{-- Error message area --}}
                    @error('introduction')
                          <p class="text-danger small">{{ $message }}</p>
                        @enderror
                </div>
                <div class="mb-3">
                    <label for="old-password" class="form-label fw-bold">Old password</label>
                    <input type="password" name="old_password" id="old-password" class="form-control" placeholder="Old Password">
                    @error('old_password')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new-password" class="form-label fw-bold">New password</label>
                    <input type="password" name="new_password" id="new-password" class="form-control" placeholder="New Password">
                    @error('new_password')
                    <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new-password-confirmation" class="form-label fw-bold">Confirm password</label>
                    <input type="password" name="new_password_confirmation" id="new-password-confirmation" class="form-control" placeholder="Confirm Password">
                    @error('new_password_confirmation')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-warning px-5">Save</button>
            </form>
        </div>
    </div>
@endsection