<div id="page-header">
    <div id="header-nav-left">
        <div class="user-account-btn dropdown">
            <a href="#" title="Mi cuenta" style="margin-right:20px" class="user-profile clearfix" data-toggle="dropdown">
                <img width="28" src="<?= base_url() ?><?= $this->session->userdata('idcliente')->imagen ?>" alt="<?= $this->session->userdata('idcliente')->admin ?>">
                <span>Hola, <?= $this->session->userdata('idcliente')->admin ?></span>
                <i class="glyph-icon icon-angle-down"></i>
            </a>
            <div class="dropdown-menu float-right">
                <div class="box-sm">
                    <div class="login-box clearfix">
                        <div class="user-img">
                            <!--<a href="#" title="" class="change-img">Change photo</a><a href="#" title="Editar Perfil">Editar Perfil</a>-->
                            <img src="<?= base_url() ?><?= $this->session->userdata('idcliente')->imagen ?>" alt="">
                        </div>
                        <div class="user-info">
                            <span>
                                Hola, <?= $this->session->userdata('idcliente')->admin ?>
                                <i><?= $this->session->userdata('idcliente')->usuario ?></i>
                            </span>
                            
                        </div>
                    </div>
                    <div class="button-pane button-pane-alt pad5L pad5R text-center">
                        <a href="<?= base_url('login/logout') ?>" class="btn btn-flat display-block font-normal btn-danger">
                            <i class="glyph-icon icon-power-off"></i>
                            Salir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #header-nav-left -->

    <div id="header-nav-right">
        <div class="dropdown" id="dashnav-btn">
            <a href="#" data-toggle="dropdown" data-placement="bottom" class="popover-button-header tooltip-button"
                title="Módulos principales">
                <i class="fa fa-cog"></i>
            </a>

            <div class="dropdown-menu float-left">
                <div class="box-sm">
                    <div class="pad5T pad5B pad10L pad10R dashboard-buttons clearfix">
                        <a href="<?= base_url() ?>" class="btn vertical-button remove-border btn-info" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-dashboard opacity-80 font-size-20"></i>
                            </span>
                            Inicio
                        </a>
                        <a href="<?= base_url('venta') ?>" class="btn vertical-button remove-border btn-danger" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon fa fa-dollar font-size-20"></i>
                            </span>
                            Compra
                        </a>
                        <a href="<?= base_url('venta') ?>" class="btn vertical-button remove-border btn-purple" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon fa fa-archive opacity-80 font-size-20"></i>
                            </span>
                            Venta
                        </a>
                        <a href="<?= base_url('proveedor') ?>" class="btn vertical-button remove-border btn-azure" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon fa fa-users opacity-80 font-size-20"></i>
                            </span>
                            Proveedores
                        </a>
                        <a href="<?= base_url('cliente') ?>" class="btn vertical-button remove-border btn-yellow" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon fa fa-user opacity-80 font-size-20"></i>
                            </span>
                            Clientes
                        </a>
                        <a href="<?= base_url('inventario') ?>" class="btn vertical-button remove-border btn-warning" title="">
                            <span class="glyph-icon icon-separator-vertical pad0A medium">
                                <i class="glyph-icon icon-laptop opacity-80 font-size-20"></i>
                            </span>
                            Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="hdr-btn" id="fullscreen-btn" title="Fullscreen">
            <i class="glyph-icon icon-arrows-alt"></i>
        </a>
    </div><!-- #header-nav-right -->

</div>