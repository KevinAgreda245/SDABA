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
                    <li class="{{ request()->is('ordenProducto*') ? 'active' : '' }}"><a href="{{ route('ordenProducto.index') }}"><i class="ti-receipt"></i> <span>Orden de compra</span></a></li>
                    @if(Auth::user()->rol->DESCRIPCION_ROL == 'Gestor de Inventario')
                        <li class="{{ request()->is('inventario*') ? 'active' : '' }}"><a href="{{ route('inventario.index') }}"><i class="ti-notepad"></i> <span>Inventario</span></a></li>
                    @endif
                    @if(Auth::user()->rol->DESCRIPCION_ROL == 'Administrador' || Auth::user()->rol->DESCRIPCION_ROL == 'Gestor de Inventario')
                    <li class="{{ request()->is('proveedor*') ? 'active' : '' }}"><a href="{{ route('proveedor.index') }}"><i class="ti-truck"></i> <span>Proveedor</span></a></li>
                    <li class="{{ request()->is('producto*') ? 'active' : '' }}"><a href="{{ route('producto.index') }}"><i class="ti-package"></i> <span>Producto</span></a></li>
                    @endif
                    @if(Auth::user()->rol->DESCRIPCION_ROL == 'Administrador')
                    <li class="{{ request()->is('reporte*') ? 'active' : '' }}"><a href="{{ route('reporte.index') }}"><i class="ti-clipboard"></i> <span>Reporte</span></a></li>
                    <li class="{{ request()->is('tipoProducto*') ? 'active' : '' }}"><a href="{{ route('tipoProducto.index') }}"><i class="ti-notepad"></i> <span>Tipo de Producto</span></a></li>
                    <li class="{{ request()->is('usuario*') ? 'active' : '' }}"><a href="{{ route('usuario.index') }}"><i class="ti-user"></i> <span>Usuario</span></a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>