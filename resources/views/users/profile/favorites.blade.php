@extends('layouts.app')
@section('title', 'favorites')
@section('content')
    @include('users.profile.header')
    {{-- Show all the posts here --}}
    <div style="margin-top: 100px">
        @if ($user->favorites->isNotEmpty())
            <div class="row">
                @foreach ($user_favorites as $favorits)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('post.show', $favorits->post->id) }}">
                            <img src="{{ $favorits->post->image }}" alt="post id {{ $favorits->post->id }}" class="grid-image">
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="text-muted text-center">No Post Yet</h3>
        @endif
    </div>
@endsection








