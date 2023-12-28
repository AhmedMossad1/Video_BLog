<nav class="navbar navbar-expand-lg fixed-top bg-danger " >
<div class="container">
    <div class="navbar-translate">
        <a class="navbar-brand" href="{{ route('frontend.landing') }}" rel="tooltip"
            title="Coded by Creative Tim" data-placement="bottom" >
            B L O G
        </a>
        <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach($categories as $category)
                        <a class="dropdown-item" href="{{ route('front.category' , ['id' => $category->id ]) }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Skills
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach($skills as $skill)
                        <a class="dropdown-item" href="{{ route('front.skill' , ['id' => $skill->id ]) }}">{{ $skill->name }}</a>
                    @endforeach
                </div>
            </li>


            <li class="nav-item dropdown" >
                <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                </a>
                <ul class="dropdown-menu" style="width: 400px;">
                <li class="head text-light bg-dark">
                <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                <span>Notifications ({{Auth::User()->unreadNotifications->count()}})</span>
                <a href="{{route('Notification.Read')}}" class="float-right text-light">Mark all as read</a>
                </div>
                </li>
                @foreach (Auth::User()->unreadNotifications as $notification)


                <li class="notification-box" style="padding: 10px 0px">
                <div class="row">
                <div class="col-lg-3 col-sm-3 col-3 text-center">

                </div>
                <div class="col-lg-8 col-sm-8 col-8">
                <strong class="text-info">{{$notification->data['user_create']}}</strong>
                <div>
                    <a href="{{ route('front.video' ,$notification->data['video_id']) }}">
                    {{$notification->data['video_name']}}
                    </a>
                </div>
                <small class="text-warning">{{$notification->created_at}}</small>
                </div>
                </div>
                </li>
                @endforeach

                <li class="footer bg-dark text-center">
                <a href="" class="text-light">View All</a>
                </li>
                </ul>
                </li>

            @guest
                <li class="nav-item">
                    <a href="{{ url('/login') }}" class="nav-link">login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/register') }}" class="nav-link">register</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('front.profile' , ['id' => auth()->user()->id]) }}" >Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
            <li>
                <form class="form-inline ml-auto" style="margin-top: 15px" action="{{ route('home') }}">
                    <div class="form-group has-white">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                    </div>
                </form>
            </li>
        </ul>
    </div>
</div>
</nav>
