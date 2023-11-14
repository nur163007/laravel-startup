<!--APP-SIDEBAR-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{ url('/dashboard') }}">
            <img src="{{URL::asset('assets/images/logos/OmniPOS-partners-panel-logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{URL::asset('assets/images/logos/OmniPOS-partners-panel-logo.png')}}"  class="header-brand-img toggle-logo" alt="logo">
            <img src="{{URL::asset('assets/images/logos/OmniPOS-partners-panel-logo.png')}}" class="header-brand-img light-logo" alt="logo">
            <img src="{{URL::asset('assets/images/logos/OmniPOS-partners-panel-logo.png')}}" class="header-brand-img light-logo1" alt="logo">
        </a><!-- LOGO -->
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
    </div>
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                <img src="" alt="user-img" class="avatar-xl rounded-circle getUserProfile">
            </div>
            <div class="user-info">
                <h6 class=" mb-0 text-dark getFullName"></h6>
                <span class="text-muted app-sidebar__user-name text-sm getCompany"></span>
            </div>
        </div>
    </div>
    <div class="sidebar-navs">
        <ul class="nav  nav-pills-circle">
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Settings">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-settings"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Chat">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-mail"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Followers">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-user"></i>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Logout">
                <a class="nav-link text-center m-2">
                    <i class="fe fe-power"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebarerr text-center font-weight-bold mt-4"></div>
    <ul class="side-menu">

    </ul>
</aside>
<!--/APP-SIDEBAR-->
