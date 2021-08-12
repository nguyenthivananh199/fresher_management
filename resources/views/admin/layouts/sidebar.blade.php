<div class="sidebar" data-color="orange">
    <!--
            Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
            -->
    <div class="logo row" style="padding-left: 25%;padding-right: 15%;">
        <a href="http://www.creative-tim.com" class="simple-text "style="width:70px;">
        <img src="/img/vmo.png" alt="logo" >
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
           <strong>Manage</strong>
            
        </a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav nav1">
            <li   id="dashboard_nav">
                <a href="/dashboard">
                    <i class="now-ui-icons design_app"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li id="profile_nav">
                <a href="/profile_admin">
                    <i class="now-ui-icons design_app"></i>
                    <p>Your profile</p>
                </a>
            </li>
            @role('Super_Admin')
            <li id="admin_nav">
                <a href="/admin">
                    <i class="now-ui-icons education_atom"></i>
                    <p>Admin management</p>
                </a>
            </li>
            <li id="role_nav">
                <a href="/role">
                    <i class="now-ui-icons education_atom"></i>
                    <p>Role management</p>
                </a>
            </li>
            @endrole
            @can('Fresher management')
            <li id="fresher_nav">
                <a href="/fresher_data">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                    <p>Fresher management</p>
                </a>
            </li>
            @endcan
            @can('Timesheet management')
            <li id="timesheet_nav">
                <a href="/">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>Timesheet management</p>
                </a>
            </li>
            <li id="request_nav">
                <a href="/request_admin">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>Request management</p>
                </a>
            </li>
            @endcan
            @can('Report management')
            <li id="report_nav">
                <a href="/report_data">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>Report management</p>
                </a>
            </li>
            @endcan

        </ul>
    <div>
    
    </div>
    </div>
</div>