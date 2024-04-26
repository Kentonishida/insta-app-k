@extends('layouts.app')
@section('title', 'All suggested Users')
@section('content')
    <div class="container content-justify-center w-75">
        <h1 class="h3 mb-4">Do you want to increase the number of followers ? </h1>
        @foreach($allSuggested_users as $user)
            <div class="row mb-2">
                <div class="col-auto">
                    <a href="{{ route('profile.show', $user->id) }}">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                        @endif
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('profile.show', $user->id )}}" class="text-decoration-none text-dark">{{ $user->name }}</a>
                </div>
                <div class="col ">
                    <form action="{{ route('follow.store',$user->id) }}" method="post">
                        @csrf
                        <button type="submit" class="border-0 bg-primary p-1 btn-sm rounded text-white">Follow</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection








