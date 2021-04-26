<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        ul{
            margin: 0;
            padding:0;
        }
        li{
            list-style: none;
        }
        .user-wrapper,.message-wrapper{
        border: 1px solid #dddddd;
        overflow-y:auto;
        }
        .user-wrapper{
            height: 600px;
        }
        .user{
            cursor: pointer;
            padding: 5px 0;
            position: relative;
        }
        .user:last-child{
            margin-bottom: 0;
        }
        .name{
        font-weight: bolder;
        font-size: 1.2em;
        }
        .pending{
            position: absolute;
            left: 13px;
            top: 9px;
            background: #b600ff;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }
        .media-left{
            margin: 0 10px;
        }
        .media-left img{
            width: 64px;
            border-radius: 64px;
        }
        .media-body p{
         padding:6px 0;
        }
        .message-wrapper{
            padding:10px;
            height: 536px;
            background: #eeeeee;
        }
        .messages .message{
            margin-bottom: 15px;
        }
        .messages .message:last-child{
            margin-bottom: 0;
        }
        .received,.sent{
            width: 45%;
            padding:3px 10px;
            border-radius: 10px;
        }
        .received{
background: #ffffff;
        }
        .sent{
            background: #8e23f3;
            color: white;
            float: right;
            text-align: right;
        }
        .message p{
            margin:5px 0;
        }
        .date{
            font-size: 12px;
        }
        .active{
            color: white;
            background: #333131;
        }
        input[type=text]{
            width: 100%;
            padding:12px 20px;
            margin: 15px 0 0 0;
            display:inline-block;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
            border:1px solid #cccccc;
        }
        input[type=text]:focus{
border: 1px solid #aaaaaa;
        }
        #titl{
            font-weight: bolder;
            color: #8e23f3;
        }
        #navbarDropdown{
            font-weight: bolder;
            color: #8e23f3;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" id="titl" href="{{ url('/') }}">
                    Messanger
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var receiver_id='';
        var my_id="{{ Auth::id() }}";
        $(document).ready(function(){
            //ajax setup for csrf tokens
            $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
            });
             // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

var pusher = new Pusher('f9ee65de56d47212b807', {
  cluster: 'ap2'
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
//   alert(JSON.stringify(data));
if(my_id==data.from){
    $('#'+data.to).click();
}else if(my_id==data.to){
 if(receiver_id==data.from){
     //if reciver is selected reload the selecter
     $('#'+data.from).click();
 }else{
   //if receiver is not sellected add notification for that reciver
   var pending=parseInt($('#'+data.from).find('.pending').html());
   if(pending){
       $('#'+data.from).find('.pending').html(pending+1);
   }else{
       $('#'+data.from).append('<span class="pending">1</span>');
   }
 }
}
});
           $('.user').click(function(){
               $('.user').removeClass('active');
               $(this).addClass('active');
               $(this).find('.pending').remove();
               receiver_id=$(this).attr('id');
               $.ajax({
                   type:"get",
                   url:"message/"+receiver_id,
                   date:"",
                   cache:false,
                   success:function(data){
                       $('#messages').html(data);
                       scrollToBottum();
                   }
               })



          $(document).on('keyup','.input-text input',function(e){
              var message=$(this).val();
              //check if inp is empty or revier is selected
              if(e.keyCode==13 && message!='' && receiver_id!=''){
                  $(this).val('');
                  var datastr="receiver_id="+receiver_id+"&message="+message;
                  $.ajax({
                      type:"post",
                      url:"message",
                      data:datastr,
                      cache:false,
                      success:function(data){

                      },
                      error:function(jqXHR,status,err){

                      },
                      complete:function(){
                        scrollToBottum();
                      }
                  })
              }
          });

           })
        });
        //make a function to scroll down auto
        function scrollToBottum(){
            $('.message-wrapper').animate({
                scrollTop:$('.message-wrapper').get(0).scrollHeight
            },50);
        }
    </script>
</body>
</html>
