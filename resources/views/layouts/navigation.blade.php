<div class="container">
    <div class="row">

<div class="col">
<nav class="navbar navbar-expand-lg bg-light">
    <!-- Primary Navigation Menu -->

        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">PHPUncover</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link active" aria-current="page">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('applications') }}" class="nav-link active" aria-current="page">Applications</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('scans') }}" class="nav-link active" aria-current="page">Scans</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notificationSettings') }}" class="nav-link active" aria-current="page">Notifications</a>
                    </li>
                </ul>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ ucwords($user->name) }} - {{ ucwords($user->organisation->name) }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('users') }}">Users</a></li>
                                <li><a class="dropdown-item" href="{{ route('samples') }}">Sample Source Code</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <div class="notification position-relative">

                        <span>
                            <a href="{{ route('notifications') }}"><i class="bi bi-bell"></i></a>
                                @if($user->unreadNotificationCount())

                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                                    {{ $user->unreadNotificationCount() }}
    <span class="visually-hidden">unread messages</span>
  </span>
                        </span>
                        @endif


                    </div>

            </div>
        </div>
</nav>
</div>
</div>
</div>
