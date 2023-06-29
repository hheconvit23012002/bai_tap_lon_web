<div class="left-side-menu mm-show">

    <div class="h-100 mm-active" id="left-side-menu-container" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <!--- Sidemenu -->
                            <ul class="metismenu side-nav mm-show">
                                <li class="side-nav-title side-nav-item">Manager</li>
                                <li class="side-nav-item ">
                                    <a href="{{ route('list_book') }}" class="side-nav-link">
                                        <span> List Book </span>
                                    </a>
                                </li>
                                @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                                    <li class="side-nav-item ">
                                        <a href="{{ route('admin.cart.index') }}" class="side-nav-link">
                                            <span> List Cart </span>
                                        </a>
                                    </li>
                                @endif
                                <li class="side-nav-item ">
                                    <a href="{{ route('user.index') }}" class="side-nav-link">
                                        <span> Home Page </span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 100px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar"
                 style="width: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
            <div class="simplebar-scrollbar"
                 style="height: 0px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
        </div>
    </div>
    <!-- Sidebar -left -->

</div>
