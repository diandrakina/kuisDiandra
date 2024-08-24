@extends('widget.navbar')

@section('title', 'Home Page')
@section('activeHome', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container" style="background-color: ">
        <h3>Notifications</h3>

        {{-- buat notification --}}
        <div class="alert alert-info " style="background-color: #9A616D; border-color: #9A616D; opacity: 50%">
            <ul class="list-unstyled mb-0">
                @forelse (Auth::user()->notifications as $notification)
                    <li>
                        {{ $notification->data['message'] }}
                        <a href="{{ route('notifications.destroy', $notification->id) }}" class="btn btn-danger btn-sm ms-2"
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $notification->id }}').submit();">
                            <i class="icon-close"></i>
                        </a>

                        <form id="delete-form-{{ $notification->id }}"
                            action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </li>
                @empty
                    <li>No new notifications</li>
                @endforelse
            </ul>
        </div>

        <div class="row mt-4">
            {{-- Search --}}
            <form method="GET" action="{{ route('user.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" placeholder="Search by name"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100"
                            style="background-color: #9A616D; border-color: #9A616D;">Search</button>
                    </div>
                </div>
            </form>

            @foreach ($dataUser as $du)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset($du->profile) }}" alt="{{ $du->name }}'s profile"
                            class="card-img-top img-fluid" style="object-fit: cover; height: 250px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $du->name }}</h5>
                            <p class="card-text">{{ $du->job }}</p>
                            <form method="POST" action="{{ route('friend_request.store') }}" class="mt-auto">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $du->id }}">
                                <button type="submit" class="btn btn-primary w-100"
                                    style="background-color: #9A616D; border-color: #9A616D;">Send Request</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection