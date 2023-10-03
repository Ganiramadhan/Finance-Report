<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <!--<li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i-->
            <!--            class="fas fa-search"></i></a></li>-->
        </ul>
        {{-- <div class="search-element">
            <input class="form-control" type="search" placeholder="Cari Data" aria-label="Search" data-width="300"
                name="search" id="search">

        </div> --}}
    </form>
    <ul class="navbar-nav navbar-right">


        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{-- <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"> --}}
                <div class="d-sm-none d-lg-inline-block"> {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Sudah Login</div>
                <a href="features-profile.html" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <form action="/logout" method="post" class="m-2">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
                </a>
            </div>
        </li>
    </ul>
</nav>
