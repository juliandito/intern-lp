<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">NEwS PORTAL</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">NP</a>
        </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class="{{ $nav_tree=='dashboard'?'active':'' }}">
                    <a class="nav-link " href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-header">Articles</li>
                <li class="nav-item dropdown {{ $nav_tree=='articles'?'active':'' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i><span>Articles</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.articles.all') }}">All Articles</a></li>
                        <li><a class="nav-link" href="{{ route('admin.articles.trashed.all') }}">Trashed Articles</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{ $nav_tree=='article-categories'?'active':'' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i><span>Article Categories</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.article-categories.all') }}">All Categories</a></li>
                    </ul>
                </li>

                <li class="menu-header">Users</li>
                <li class="nav-item dropdown {{ $nav_tree=='users'?'active':'' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>Users</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.users.all') }}">All Users</a></li>
                    </ul>
                </li>
            </ul>
    </aside>
</div>
