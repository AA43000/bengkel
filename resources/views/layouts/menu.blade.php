<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database"></i>
        <p>
            Master
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
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
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>User</p>
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
