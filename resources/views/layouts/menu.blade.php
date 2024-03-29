<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
@if(auth()->user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('setting.index') }}" class="nav-link">
        <i class="nav-icon fas fa-cog"></i>
        <p>Setting</p>
    </a>
</li>
@endif
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database"></i>
        <p>
            Master
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        @if(auth()->user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('cabang.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Cabang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>User</p>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a href="{{ route('produk.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Produk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('supplier.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Supplier</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pelanggan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pelanggan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sales.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sales</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('mekanik.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Mekanik</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('kendaraan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kendaraan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-shopping-cart"></i>
        <p>
            Transaksi
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('tpembelian.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Transaksi Pembelian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tpenjualan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Transaksi Penjualan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('item_keluar.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Item Keluar</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('service.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Service</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tukartambah.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tukar Tambah</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Laporan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('lpembelian.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Pembelian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('lpenjualan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Penjualan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('litemkeluar.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Item Keluar</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('lservice.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Service</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ltukartambah.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Tukar Tambah</p>
            </a>
        </li>
    </ul>
</li>