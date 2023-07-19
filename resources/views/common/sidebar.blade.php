<!-- Sidebar -->
<ul class="navbar-nav app-theme sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-text mx-3">Linn Training</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    <li class="nav-item {{ activeRoute(url('dashboard')) }}">
        <a class="nav-link" href="{{ url('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-solid fa-screen-users"></i>
            <span>Student Management</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ url('enquiries') }}">
                    <i class="fa-solid fa-solid fa-file-pen"></i><span>Enquiries</span>
                </a>

                <a class="collapse-item" href="{{ url('students') }}">
                    <i class="fas fa-solid fa-screen-users"></i><span>Student</span>
                </a>
                <!--  <a class="collapse-item" href="{{ url('student_card_generate') }}">
                    <i class="fa-solid fa-address-card"></i><span>Card Generate</span>
                </a> -->

                <a class="collapse-item" href="{{ url('certificates') }}">
                    <i class="fa-solid fa-solid fa-file-certificate"></i>
                    <span>Certificate</span></a>

                <a class="collapse-item" href="{{ route('certificate_history') }}">
                    <i class="fa-solid fa-solid fa-file-certificate"></i>
                    <span>Certificate History</span>
                </a>
            </div>
        </div>
    </li>




    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAttendance"
            aria-expanded="true" aria-controls="collapseAttendance">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Attendance Management</span>
        </a>
        <div id="collapseAttendance" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a target="_blank" class="collapse-item" href="{{ url('attendance') }}">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Attendance</span>
                </a>

                <a class="collapse-item" href="{{ url('att_history') }}">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i>
                    <span>Attendance History</span></a>


                <a class="collapse-item" href="{{ url('att_summary') }}">
                    <i class="fa-solid fa-books-medical mr-2"></i>
                    <span>Attendance Summary</span></a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoice"
            aria-expanded="true" aria-controls="collapseInvoice">
            <i class="fa-solid fa-receipt"></i>
            <span>Invoice Management</span>
        </a>
        <div id="collapseInvoice" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ url('invoice') }}">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Invoice</span></a>


                <a class="collapse-item" href="{{ url('invoice_summary') }}">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Invoice Summary</span></a>

            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
            aria-expanded="true" aria-controls="collapseMaster">
            <i class="fa-solid fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseMaster" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="{{ url('batch') }}">
                    <i class="fas fa-megaphone"></i>
                    <span>Batch</span></a>


                <a class="collapse-item" href="{{ url('time_tables') }}">
                    <i class="fas fa-calendar-clock"></i>
                    <span>Time Table</span></a>

                <a class="collapse-item" href="{{ route('course.index') }}">
                    <i class="fa-solid fa-solid fa-graduation-cap"></i>
                    <span>Course</span>
                </a>

                <a class="collapse-item" href="{{ route('major.index') }}">
                    <i class="fa-solid fa-book-open-cover"></i>
                    <span>Major</span>
                </a>

                <a class="collapse-item" href="{{ route('users.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>


                <a class="collapse-item" href="{{ route('setting.index') }}">
                    <i class="fa-solid fa-solid fa-sliders"></i>
                    <span>Setting</span>
                </a>

            </div>
        </div>
    </li>

    <!-- <li class="nav-item {{ activeRoute(url('invoice')) }}">
        <a class="nav-link" href="{{ url('invoice') }}">
            <i class="fa-solid fa-receipt"></i>
            <span>Invoice</span></a>
    </li>


    

    <li class="nav-item {{ activeRoute(url('certificate_history')) }}">
        <a class="nav-link" href="{{ route('certificate_history') }}">
            <i class="fa-solid fa-solid fa-file-certificate"></i>
            <span>Certificate History</span>
        </a>
    </li> -->



    <!-- Setting -->
    <!-- <li class="nav-item {{ activeRoute(url('setting')) }}">
        <a class="nav-link" href="{{ route('setting.index') }}">
            <i class="fa-solid fa-solid fa-sliders"></i>
            <span>Setting</span>
        </a>
    </li> -->

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
                Menus
            </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Configurations</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Configurations:</h6>
                        <a class="collapse-item" href="">Setting</a>
                        <a class="collapse-item" href="">Cards</a>
                    </div>
                </div>
            </li> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
                Interface
            </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="{{url('button')}}">Buttons</a>
                        <a class="collapse-item" href="{{url('card')}}">Cards</a>
                    </div>
                </div>
            </li> --}}

    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="{{ url('color') }}">Colors</a>
                        <a class="collapse-item" href="{{ url('border') }}">Borders</a>
                        <a class="collapse-item" href="{{ url('animation') }}">Animations</a>
                        <a class="collapse-item" href="{{ url('other') }}">Other</a>
                    </div>
                </div>
            </li>  -->

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
                Addons
            </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li> --}}

    <!-- Nav Item - Charts -->
    {{-- <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li> --}}

    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item">
                <a class="nav-link" href="{{url('table')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li> --}}

    <!-- Divider -->
    {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    {{-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> --}}

</ul>
