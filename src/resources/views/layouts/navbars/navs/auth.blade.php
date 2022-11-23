<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute mt-2">
    <div class="container">
        <div class="navbar-wrapper position-absolute top-50 start-50 translate-middle">
            <a id="titlePage" class="navbar-brand justify-content-center" href="{{ route('timesheet') }}"><strong>{{ $titlePage }}</strong></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdownStartLink" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-play"></i>
                        <p class="d-lg-none d-md-block">
                            {{ __('Stats') }}
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownStartLink">
                        <span class="m-2">{{ __('Restart one of your last activities') }}</span>
                        <a class="dropdown-item" href="{{route('timesheet')}}">{{ __('Items') }}</a>
                        <a class="dropdown-item modal_form addRecord btn btn-default" href="#" data-bs-toggle="modal"
                        data-bs-target="#newRecord">{{ __('Create a record') }}</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdownProfile" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                            {{ __('Account') }}
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="{{ route('user', auth()->user())}}">{{ __('Profile') }}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }} ">{{ __('Log out') }}</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Get this party started?</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Turn up the jams and have a good time.</div>
                    <div class="modal-footer">
                        <button class="btn btn-text-primary me-2" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-text-primary" type="button">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
