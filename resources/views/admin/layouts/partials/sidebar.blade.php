<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
    <ul class="navigation-left">
       @can('Məntəqələr')
            <li class="nav-item " data-item="stations">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Məntəqələr</span>
                </a>
                <div class="triangle"></div>
            </li>
        @endcan

        @can('Məlumatlar')
        <li class="nav-item " data-item="data">
            <a class="nav-item-hold" href="#">
                <i class="nav-icon i-Bar-Chart"></i>
                <span class="nav-text">Məlumatlar</span>
            </a>
            <div class="triangle"></div>
        </li>
        @endcan
        @can('İstifadəçilər')
        <li class="nav-item " data-item="users">
            <a class="nav-item-hold" href="#">
                <i class="nav-icon i-Bar-Chart"></i>
                <span class="nav-text">İstifadəçilər</span>
            </a>
            <div class="triangle"></div>
        </li>
        @endcan

            <li class="nav-item">
                <a class="nav-item-hold" href="{{route('logs')}}">
                    <i class="nav-icon i-Light-Bulb"></i>
                    <span class="nav-text">Loqlar</span>
                </a>
                <div class="triangle"></div>
            </li>
    </ul>
</div>

<div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
    <!-- Submenu Dashboards -->
    <ul class="childNav" data-parent="stations">
        @can('Bütün məntəqələr')
        <li class="nav-item ">
            <a class=""
               href="{{ route('stations.all-stations') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Bütün məntəqələr</span>
            </a>
        </li>
        @endcan
        @foreach($stations as $station)
            @can($station->station_name)
                <li class="nav-item ">
                    <a class=""
                    href="{{ route('stations.show', $station->id) }}">
                        <i class="nav-icon i-Cash-register-2"></i>
                        <span class="item-name">{{$station->station_name}}</span>
                    </a>
                </li>
            @endcan
        @endforeach
    </ul>

    <ul class="childNav" data-parent="data">
        @can('Tezliklər')
        <li class="nav-item ">
            <a class=""
               href="{{ route('frequencies.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Tezliklər</span>
            </a>
        </li>
        @endcan
        @can('Proqram adları')
        <li class="nav-item ">
            <a class=""
               href="{{ route('program-names.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Proqram adları</span>
            </a>
        </li>
        @endcan
        @can('İstiqamətlər')
        <li class="nav-item ">
            <a class=""
               href="{{ route('directions.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">İstiqamətlər</span>
            </a>
        </li>
        @endcan
        @can('Yayım yerləri')
        <li class="nav-item ">
            <a class=""
               href="{{ route('program-locations.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Yayım yerləri</span>
            </a>
        </li>
        @endcan
        @can('Proqram dilləri')
        <li class="nav-item ">
            <a class=""
               href="{{ route('program-languages.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Proqram dilləri</span>
            </a>
        </li>
        @endcan
    </ul>

    <ul class="childNav" data-parent="users">
        @can('Məntəqələr üzrə istifadəçilər')
        <li class="nav-item ">
            <a class=""
               href="{{ route('stations-users.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Məntəqələr üzrə</span>
            </a>
        </li>
        @endcan
        @can('Sistem istifadəçiləri')
        <li class="nav-item ">
            <a class=""
               href="{{ route('system-users.index') }}">
                <i class="nav-icon i-Add"></i>
                <span class="item-name">Administratorlar</span>
            </a>
        </li>
        @endcan

        @can('Vəzifələr')
        <li class="nav-item ">
            <a class=""
               href="{{ route('roles.index') }}">
                <i class="nav-icon i-Add"></i>
                <span class="item-name">Vəzifələr</span>
            </a>
        </li>
        @endcan
    </ul>
</div>
<div class="sidebar-overlay"></div>
