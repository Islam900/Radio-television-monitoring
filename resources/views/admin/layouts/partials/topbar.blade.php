<div class="main-header">
    <div class="logo">
        <a href="{{route('dashboard')}}">
            <img src="{{ asset('assets/images/logo.png')}}" alt="" class="main-logo">
        </a>
    </div>

    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->

        <!-- Notificaiton -->
        <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                <span class="badge badge-primary">{{$unread_notifications_count>0 ? $unread_notifications_count : ''}}</span>
                <i class="i-Bell text-muted header-icon"></i>
            </div>
            <!-- Notification dropdown -->
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none"
                 aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                @forelse($notifications as $notf)
                    <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                            <i class="i-Receipt-3 text-success mr-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                            <p class="m-0 d-flex align-items-center">
                                <span><strong>Bildiriş</strong></span>
                                <span class="badge badge-pill badge-success ml-1 mr-1">Yeni</span>
                                <span class="flex-grow-1"></span>
                                <span class="text-small text-muted ml-auto">{{ \Carbon\Carbon::parse($notf->created_at)->format('d.m.Y') }}</span>
                            </p>
                            <p class="text-small {{$notf->r_read == 0 ? 'font-weight-700' : ''}} m-0">
                                {{ $notf->content }}
                            </p>
                        </div>
                    </div>
                @empty

                    <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                            <i class="i-Receipt-3 text-success mr-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                            <p class="text-small m-0">
                                Yeni bildiriş yoxdur
                            </p>
                        </div>
                    </div>

                @endforelse

            </div>
        </div>
        <!-- Notificaiton End -->

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <a href="#" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <h5>{{Auth::user()->name_surname}}</h5>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{Auth::user()->name_surname}}
                    </div>
                    <a class="dropdown-item" href="{{ route('station-profile') }}">Hesab məlumatları</a>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button class="dropdown-item">
                            Çıxış
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
