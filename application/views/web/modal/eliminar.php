<!-- Modal -->
<div id="modalelminar" class="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar <?= $title ?></h4>
            </div>
            <div class="modal-body">
                <center id="panel-seguro">
                    <i class="fa fa-warning fa-5x" style="color: #f89406"></i>
                    <h3 id="text-title" style="font-weight: 900">Al eliminar no podrá recuperar datos</h3>
                    <h3 id="text-descripcion">¿Está seguro de eliminar?</h3>
                </center>
                <center id="panel-eliminando" style="display: none">
                    <i class="fa fa-refresh fa-spin fa-5x" style="color: #5CB85C"></i>
                    <h3 id="text-titleeliminando" style="font-weight: 900">¡Eliminando el dato!</h3>
                    <h3 id="text-descripcioneliminando">Espere....</h3>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="aceptareliminar">Eliminar</button>
            </div>
        </div>

    </div>
</div>