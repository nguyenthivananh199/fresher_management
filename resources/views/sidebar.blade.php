<div class="sidebar" data-color="orange">
            <!--
            Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
            -->
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                    CT
                </a>
                <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                    Creative Tim
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="active ">
                        <a href="/dashboard">
                            <i class="now-ui-icons design_app"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @role('Super_Admin')
                    <li>
                        <a href="/admin">
                            <i class="now-ui-icons education_atom"></i>
                            <p>Admin management</p>
                        </a>
                    </li>
                    <li>
                        <a href="/role">
                            <i class="now-ui-icons education_atom"></i>
                            <p>Role management</p>
                        </a>
                    </li>
                    @endrole
                    @can('Fresher management')
                    <li>
                        <a href="/fresher_data">
                            <i class="now-ui-icons ui-1_bell-53"></i>
                            <p>Fresher management</p>
                        </a>
                    </li>
                    @endcan
                    @can('Timesheet management')
                    <li>
                        <a href="/">
                            <i class="now-ui-icons users_single-02"></i>
                            <p>Timesheet management</p>
                        </a>
                    </li>
                    @endcan
                    @can('Report management')
                    <li>
                        <a href="/report_data">
                            <i class="now-ui-icons design_bullet-list-67"></i>
                            <p>Report management</p>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>