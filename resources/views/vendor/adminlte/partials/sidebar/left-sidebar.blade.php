<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('student.dashboard') }}"
        class="brand-link">
        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu" @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif
                @if(!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>

                {{-- Check User Role --}}
                @if(auth()->user()->role == 'admin')
                    {{-- Admin Sidebar --}}

                    <li class="nav-item">
                        <a href="{{ route('admin.students.create') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>Add Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.list') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>List of Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.enrollments.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>Enrollments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>Add Grades</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.subjects.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Subjects List</p>
                        </a>
                    </li>
                @elseif(auth()->user()->role == 'student')
                    {{-- Student Sidebar --}}
                    <li class="nav-item">
                        <a href="{{ route('student.grades.index') }}" class="nav-link">

                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>Grades</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>