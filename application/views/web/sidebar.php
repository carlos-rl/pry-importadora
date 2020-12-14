<div id="mobile-navigation">
    <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span>
    </button>
</div>
<div id="page-sidebar">
    <div id="header-logo" class="logo-bg">
        <a href="<?= base_url('menu') ?>"  class="logo-content-big" title="<?= $this->session->userdata('idimportadora')->nombre ?>">
            
            <?= $this->session->userdata('idimportadora')->nombre ?>
        </a>
        <a href="<?= base_url('menu') ?>" class="logo-content-small" title="<?= $this->session->userdata('idimportadora')->nombre ?>">
            <?= substr($this->session->userdata('idimportadora')->nombre, 0, 2); ?>...
        </a>
        <a id="close-sidebar" href="#" title="Close sidebar">
            <i class="glyph-icon icon-outdent"></i>
        </a>
    </div>
    <div class="scroll-sidebar">
        <ul id="sidebar-menu">
            <li class="header"><span>Administración</span></li>
            <li>
                <a href="<?= base_url('menu') ?>" title="Inicio">
                    <i class="glyph-icon fa fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li <?= esVisible($data_accessos, 'importadora') ?>>
                <a href="<?= base_url('importadora/index/edit/1') ?>" title="Importadora">
                    <i class="glyph-icon fa fa-cog"></i>
                    <span>Importadora</span>
                </a>
            </li>
            <li <?= esVisible($data_accessos, 'usuario') ?>>
                <a href="<?= base_url('usuario') ?>" title="Respaldo BD">
                    <i class="glyph-icon fa fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li <?= esVisible($data_accessos, 'roles') ?>>
                <a href="<?= base_url('roles') ?>" title="Respaldo BD">
                    <i class="glyph-icon fa fa-cog"></i>
                    <span>Autorización</span>
                </a>
            </li>
            <li <?= esVisible($data_accessos, 'respaldo') ?>>
                <a href="<?= base_url('menu/database_backup') ?>" title="Respaldo BD">
                    <i class="glyph-icon fa fa-database"></i>
                    <span>Respaldo BD</span>
                </a>
            </li>
            <li class="header"><span>Módulos</span></li>
            <li>
                <a href="javascript:void(0);" title="Otros módulos">
                    <i class="glyph-icon fa fa-list"></i>
                    <span>Otros módulos</span>
                </a>

                <div class="sidebar-submenu">
                    <ul>
                        <li <?= esVisible($data_accessos, 'marca') ?>><a href="<?= base_url('marca') ?>" title="Marcas"><span>Marcas</span></a></li>
                        <li <?= esVisible($data_accessos, 'tipogasto') ?>><a href="<?= base_url('tipogasto') ?>" title="Tipo de gastos"><span>Tipo de gastos</span></a></li>
                        <li <?= esVisible($data_accessos, 'banco') ?>><a href="<?= base_url('banco') ?>" title="Bancos"><span>Bancos</span></a></li>
                    </ul>

                </div><!-- .sidebar-submenu -->
            </li>
            <li>
                <a href="javascript:void(0);" title="Módulo de financiamiento">
                    <i class="glyph-icon fa fa-dollar"></i>
                    <span>Módulo de financiamiento</span>
                </a>

                <div class="sidebar-submenu">
                    <ul>
                        <li <?= esVisible($data_accessos, 'compras') ?>><a href="<?= base_url('compras') ?>" title="Compras de mercadería"><span>Compras de mercadería</span></a></li>
                        <li <?= esVisible($data_accessos, 'gasto') ?>><a href="<?= base_url('gasto') ?>" title="Pago de gastos en general"><span>Pago de gastos en general</span></a></li>
                        <li <?= esVisible($data_accessos, 'proveedor') ?>><a href="<?= base_url('proveedor') ?>" title="Provedores"><span>Provedores</span></a></li>
                        <li <?= esVisible($data_accessos, 'ctaporpagar') ?>><a href="<?= base_url('ctaporpagar') ?>" title="Cuentas por pagar"><span>Cuentas por pagar</span></a></li>
                    </ul>

                </div><!-- .sidebar-submenu -->
            </li>
            <li>
                <a href="javascript:void(0);" title="Módulo de financiamiento">
                    <i class="glyph-icon fa fa-archive"></i>
                    <span>Módulo de facturación</span>
                </a>

                <div class="sidebar-submenu">
                    <ul>
                        <li <?= esVisible($data_accessos, 'ventas') ?>><a href="<?= base_url('ventas') ?>" title="Ventas"><span>Ventas</span></a></li>
                        <li <?= esVisible($data_accessos, 'credito') ?>><a href="<?= base_url('credito') ?>" title="Gestión de créditos"><span>Gestión de créditos</span></a></li>
                        <li <?= esVisible($data_accessos, 'cliente') ?> ><a href="<?= base_url('cliente') ?>" title="Clientes"><span>Registro de Clientes</span></a></li>
                        <li <?= esVisible($data_accessos, 'ctabancaria') ?>><a href="<?= base_url('ctabancaria') ?>" title="Cuentas bancarias"><span>Cuentas bancarias</span></a></li>
                        <li <?= esVisible($data_accessos, 'deposito') ?>><a href="<?= base_url('deposito') ?>" title="Depósitos"><span>Depósitos</span></a></li>
                        <li <?= esVisible($data_accessos, 'devolverventa') ?>><a href="<?= base_url('devolverventa') ?>" title="Devoluciones"><span>Devoluciones</span></a></li>
                    </ul>

                </div><!-- .sidebar-submenu -->
            </li>
            <li>
                <a href="javascript:void(0);" title="Otros módulos">
                    <i class="glyph-icon fa fa-file-archive-o"></i>
                    <span>Módulo de inventario</span>
                </a>

                <div class="sidebar-submenu">
                    <ul>
                        <li <?= esVisible($data_accessos, 'mercaderia') ?>><a href="<?= base_url('mercaderia') ?>" title="Mercadería"><span>Mercadería</span></a></li>
                        <li <?= esVisible($data_accessos, 'inventario') ?>><a href="<?= base_url('inventario') ?>" title="Gestión de mercadería"><span>Gestión de mercadería</span></a></li>
                        <li <?= esVisible($data_accessos, 'devolvercompra') ?>><a href="<?= base_url('devolvercompra') ?>" title="Devoluciones de compras"><span>Devoluciones de compras</span></a></li>
                    </ul>
                </div><!-- .sidebar-submenu -->
            </li>
            <li>
                <a href="javascript:void(0);" title="Otros módulos">
                    <i class="glyph-icon fa fa-bar-chart"></i>
                    <span>Módulo de informes</span>
                </a>

                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="<?= base_url('venta/informe') ?>" title="Informe de ventas"><span>Ventas</span></a></li>
                        <li><a href="<?= base_url('compra/informe') ?>" title="Informe de compras"><span>Compras</span></a></li>
                        <li><a href="<?= base_url('gasto/informe') ?>" title="Informe de Gastos"><span>Gastos</span></a></li>
                        <li><a href="<?= base_url('proveedor/informe') ?>" title="Informe de Proveedor"><span>Proveedor</span></a></li>
                        <li><a href="<?= base_url('ctaporpagar/informe') ?>" title="Informe de cuenta por pagar"><span>Informe de cuenta por pagar</span></a></li>
                        <li><a href="<?= base_url('credito/informe') ?>" title="Informe de ventas a créditos"><span>Informe de ventas a créditos</span></a></li>
                        <li><a href="<?= base_url('devolverventa/informe') ?>" title="Informe de devoluciones"><span>Informe de devoluciones</span></a></li>
                    </ul>
                </div><!-- .sidebar-submenu -->
            </li>
            
        </ul><!-- #sidebar-menu -->
    </div>
</div>