<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('main') }}"><img src="{{ asset('img/icon/logo.png') }}" class="img-fluid img-logo" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{ request()->is('main') ? 'active' : '' }}"><a href="{{ route('main') }}"><i class="ti-home"></i> <span>Inicio</span></a></li>
                    <li><a href="#"><i class="ti-receipt"></i> <span>Orden de compra</span></a></li>
                    <li class="{{ request()->is('inventario*') ? 'active' : '' }}"><a href="{{ route('inventario.index') }}"><i class="ti-notepad"></i> <span>Inventario</span></a></li>
                    <li class="{{ request()->is('proveedor*') ? 'active' : '' }}"><a href="{{ route('proveedor.index') }}"><i class="ti-truck"></i> <span>Proveedor</span></a></li>
                    <li class="{{ request()->is('producto*') ? 'active' : '' }}"><a href="{{ route('producto.index') }}"><i class="ti-package"></i> <span>Producto</span></a></li>
                    <li class="{{ request()->is('tipoProducto*') ? 'active' : '' }}"><a href="{{ route('tipoProducto.index') }}"><i class="ti-notepad"></i> <span>Tipo de Producto</span></a></li>
                    <li><a href="#"><i class="ti-user"></i> <span>Usuario</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>