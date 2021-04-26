@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                <ul class="users">
                @foreach($users as $user)
                <li class="user" id="{{$user->id}}">
                    @if($user->unread)
                    <span class="pending">{{$user->unread}}</span>
                    @endif
                    <div class="media">
                        <div class="media-left">
                            <img src="{{asset('/j.png')}}">
                            {{-- <div style="height:100px;width:100px;background-color:lightblue;"></div> --}}
                        </div>
                        <div class="media-body">
                            <span class="name">{{$user->name}}</span><br/>
                            <span class="email">{{$user->email}}</span>
                        </div>
                    </div>
                </li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-8" id="messages">
        </div>
    </div>
</div>
@endsection
