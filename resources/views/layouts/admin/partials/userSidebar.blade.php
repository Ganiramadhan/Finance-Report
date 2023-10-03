<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="../../../img/mki.png" alt="icon" class="loading-icon" width="50" height="50"> <a
                href="#">Laporan Keuangan</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="../../../img/mki.png" alt="icon" class="loading-icon" width="50" height="50">
        </div>
        <ul class="sidebar-menu">

            <li class="nav-item ">
                <a href="/admin" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>

            </li>
            <li class="menu-header">MENU</li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i>
                    <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="/user/product"><i class="fas fa-box"></i> Product</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/user/customer"><i class="fas fa-users"></i> Customer</a>
                    </li>

            </li>
            <li>
                <a class="nav-link" href="/user/supplier"><i class="fas fa-truck"></i> Supplier</a>
            </li>
        </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                <span>Transaksi</span></a>
            <ul class="dropdown-menu">
                <li>
                    <a class="nav-link" href="/user/penjualan"><i class="fas fa-shopping-cart"></i> Penjualan</a>
                </li>
                {{-- <li> <a class="nav-link" href="{{ route('pembelian.index') }}"><i class="fas fa-shopping-basket"></i>
                        Pembelian</a></li>
                <li> <a class="nav-link" href="{{ route('pembayaran.index') }}"><i class="fas fa-money-bill"></i>
                        Pembayaran</a>
                </li>
                <li> <a class="nav-link" href="{{ route('transaksi.index') }}"><i class="fas fa-exchange-alt"></i>
                        Transaksi Lainnya</a>
                </li> --}}
            </ul>
        </li>

        <li class="nav-item ">
            <a class="nav-link" href="/user/utang"><i class="fas fa-money-check"></i>
                <span>Utang</span></a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="/user/piutang"><i class="fas fa-money-check-alt"></i>
                <span>Piutang </span> </a>
        </li>
        {{-- <li class="menu-header">Lainnya</li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i>
                <span>Data Lainnya</span></a>

            <ul class="dropdown-menu">
                <li> <a class="nav-link" href="{{ route('metode_pembayaran.index') }}"><i class="fas fa-university"></i>
                        Akun Bank</a>
                </li>
                <li> <a class="nav-link" href="{{ route('jenis_transaksi.index') }}"><i class="fas fa-list-alt"></i>
                        Jenis Transaksi</a>
                </li>
                <li> <a class="nav-link" href="{{ route('kategori_pengeluaran.index') }}"><i
                            class="fas fa-money-bill-wave"></i> Jenis Pengeluaran</a>
                </li>
            </ul>
        </li>
        </ul> --}}

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">

            <form action="/logout" method="post" class="m-2">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg btn-block"> <i class="fas fa-sign-out-alt"></i>

                    Logout</button>
            </form>
        </div>


    </aside>
</div>
