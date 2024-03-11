

<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
    <ul class="navigation-left">
        <li class="nav-item " data-item="dashboard-local">
            <a class="nav-item-hold" href="#">
                <i class="nav-icon i-Bar-Chart"></i>
                <span class="nav-text">Yerli yayımlar</span>
            </a>
            <div class="triangle"></div>
        </li>

        <li class="nav-item " data-item="dashboard-foreign">
            <a class="nav-item-hold" href="#">
                <i class="nav-icon i-Bar-Chart"></i>
                <span class="nav-text">Kənar yayımlar</span>
            </a>
            <div class="triangle"></div>
        </li>


    </ul>
</div>

<div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
    <!-- Submenu Dashboards -->
    <ul class="childNav" data-parent="dashboard-local">
        <li class="nav-item ">
            <a class=""
               href="{{ route('local-broadcasts.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Yerli hesabatlar</span>
            </a>
        </li>
        @if($local_broadcast_button_status)
        <li class="nav-item ">
            <a class=""
               href="{{ route('local-broadcasts.create') }}">
                <i class="nav-icon i-Add"></i>
                <span class="item-name">Hesabat əlavə edin</span>
            </a>
        </li>
        @endif
    </ul>

    <ul class="childNav" data-parent="dashboard-foreign">
        <li class="nav-item ">
            <a class=""
               href="{{ route('foreign-broadcasts.index') }}">
                <i class="nav-icon i-Cash-register-2"></i>
                <span class="item-name">Kənar hesabatlar</span>
            </a>
        </li>
        @if($foreign_broadcast_button_status)
        <li class="nav-item ">
            <a class=""
               href="{{ route('foreign-broadcasts.create') }}">
                <i class="nav-icon i-Add"></i>
                <span class="item-name">Hesabat əlavə edin</span>
            </a>
        </li>
        @endif
    </ul>
</div>
<div class="sidebar-overlay"></div>
