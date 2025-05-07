@extends('layouts.user')

@section('content')
<div class="container">
    <h1>Your Notifications</h1>

    @if($notifications->count())
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $notification->data['trader_name'] }}</strong>: 
                        {{ $notification->data['percentage_change'] }}% => 
                        {{ number_format($notification->data['gain_loss'], 2) }}
                        <br>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    @if($notification->read_at === null)
                        <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-primary">Mark as read</button>
                        </form>
                    @else
                        <span class="badge bg-success">Read</span>
                    @endif
                </li>
            @endforeach
        </ul>

        {{ $notifications->links() }}
    @else
        <p>You have no notifications.</p>
    @endif
</div>
@endsection
