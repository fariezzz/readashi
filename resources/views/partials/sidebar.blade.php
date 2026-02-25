<div class="wrapper d-flex flex-column">
    <aside id="sidebar">
        <div class="d-flex container-fluid mt-3 sidebar-header">
            <div class="sidebar-logo mx-3">
                <a href="/"><img src="{{ asset('logo/logo.png') }}" width="50" height="auto" alt=""></a>
            </div>
            <div class="sidebar-logo-text brand-font mt-3">
                <a href="/">Readashi</a>
            </div>
        </div>
        <ul class="sidebar-nav py-3">
            <li class="sidebar-item">
                <a href="/" class="sidebar-link {{ Request::is('/') ? 'link-active' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/profile" class="sidebar-link {{ Request::is('profile*') ? 'link-active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profile</span>
                </a>
            </li>

            @can('admin')
            <li class="sidebar-item">
                <a href="/users" class="sidebar-link {{ Request::is('users*') ? 'link-active' : '' }}">
                    <i class="bi bi-person-vcard"></i>
                    <span>Users</span>
                </a>
            </li>
            @endcan

            <li class="sidebar-item">
                <a href="/manga" class="sidebar-link {{ Request::is('manga*') ? 'link-active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span>Mangas</span>
                </a>
            </li>
            
            @can('admin')
            <li class="sidebar-item">
                <a href="/genre" class="sidebar-link {{ Request::is('genre*') ? 'link-active' : '' }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Genres</span>
                </a>
            </li>
            @endcan

            <li class="sidebar-item">
                <a href="/member" class="sidebar-link {{ Request::is('member*') ? 'link-active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Members</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/borrowing" class="sidebar-link {{ Request::is('borrowing*') ? 'link-active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Borrowings</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a href="#" id="logoutButton" class="sidebar-link mb-3">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
            <form id="logoutForm" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
            {{-- <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="sidebar-link btn btn-link text-decoration-none text-white mx-2 mb-4">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="logout-text">Logout</span>
                </button>
            </form> --}}
        </div>
    </aside>
{{-- </div> --}}


