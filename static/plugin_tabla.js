(function ($) {
    var dataTable;
    var urlsC = '';
    var id_text = '';
    $.extend({
        base64Img: null,
        tablaAjax: function (data) {
            id_text = data.id;
            var img = null;
            this.imgToBase64(data.image, function (base64) {
                this.base64Img = base64;
                img = base64;
            });
            urlsC = data.ajax.urlEliminar;
            if (tabla.dibujarTabla(data)) {
                dataTable = $('#tabla').DataTable({
                    fixedHeader: data.fixedHeader,
                    "destroy": true,
                    "processing": false,
                    "responsive": (data.responsive === true ? true : false),
                    "order": data.group.order,
                    "paging": (data.paging === true ? true : null),
                    "lengthMenu": [data.lengthMenu, data.lengthMenu],
                    "rowsGroup": (data.group.estado === true ? data.group.column : null),
                    "language": tabla.españolDataTable(),
                    "ajax": {
                        "url": data.ajax.url,
                        "type": "POST",
                        "data": data.ajax.data
                    },
                    "initComplete": function (setting, json) {
                        tabla.contextMenu(data);
                        tabla.completarDatos(data);
                    },
                    "columnDefs": [
                        {
                            "orderable": false, "className": 'middle select-checkbox', "targets": 0
                        }
                    ],
                    "dom": "<'row' <'text-center'B>>"//BOTONES
                            + "<'row' <'col-sm-3'l>"//LENGHT
                            + "<'col-sm-9'f>>"//BUSCAR
                            + "<rt>"//ABAJO
                            + "<'row'"
                            //+ " <'col-sm-3 col-md-3 col-lg-3'l>"//LENGHT
                            + " <'col-sm-6 col-md-6 col-lg-6'i>"//INFO
                            + "<'col-sm-6 col-md-6 col-lg-6'p>>", //"Bfrtip",
                    buttons: tabla.crearBoton(data),
                    "select": {"style": "multi", "selector": "td.select-checkbox"},
                    "columns": tabla.columns(data)
                });
                return dataTable;
            }
        },
        imgToBase64: function (url, callback) {
            if (!window.FileReader) {
                callback(null);
                return;
            }
            var xhr = new XMLHttpRequest();
            xhr.responseType = 'blob';
            xhr.onload = function () {
                var reader = new FileReader();
                reader.onloadend = function () {
                    callback(reader.result.replace('text/xml', 'image/jpeg'));
                };
                reader.readAsDataURL(xhr.response);
            };
            xhr.open('GET', url);
            xhr.send();
        },
        getImageFromUrl: function (url, callback) {
            var img = new Image();
            img.onError = function () {
                alert('Cannot load image: "' + url + '"');
            };
            img.onload = function () {
                callback(img);
            };
            img.src = url;
        },
        eliminarAjax: function (id) {
            tabla.eliminarAjax(tabla.objtEliminar(id, id_text));
        },
        objtEdit: function (id) {
            return tabla.objtEliminar(id, id_text);
        },
        tablaMdos: function () {
            tabla.metodos();
        },
        ajaxTabla: function (data) {
            return $.ajax({
                url: data.url,
                type: 'POST',
                data: data.data,
                dataType: 'json',
                timeout: 15000,
                beforeSend: function () {
                    //ANTES DE ENVIAR
                    $('#' + data.idForm).find('input, textarea, button, select').prop('disabled', true);
                    $('#' + data.idIcon).removeClass('fa-save');
                    $('#' + data.idIcon).addClass('fa-refresh fa-pulse');
                    $('#' + data.TextButton).html('Espere.....');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        progressBar: true,
                        hideDuration: 3000
                    };
                    if (jqXHR.status === 0) {
                        toastr.error('No estás conectado, verifica tu conección.');
                    } else if (jqXHR.status == 404) {
                        toastr.error('Respuesta, página no existe [504].');
                    } else if (jqXHR.status == 500) {
                        toastr.error('Error interno del servidor [500].');
                    } else if (textStatus === 'parsererror') {
                        toastr.error('Respuesta JSON erróneo.');
                    } else if (textStatus === 'timeout') {
                        toastr.error('Error, tiempo de respuesta.');
                    } else if (textStatus === 'abort') {
                        toastr.error('Respuesta ajax abortada.');
                    } else {
                        toastr.error('Uncaught Error: ' + jqXHR.responseText);
                    }
                }
            });
        },
        formulario: function (data) {
            var id = data.id;
            var html = '';
            for (var i in data.atributos) {
                var ins = data.atributos[i];
                html = '<div class="form-group">';
                html += '<label for="' + ins.id + '" class="control-label col-md-4 col-sm-3 col-xs-12">' + ins.text + ' ' + (ins.required == true ? '*' : '') + '</label>';
                html += '<div class="col-md-6 col-sm-6 col-xs-12">';
                if (ins.type == 'input') {
                    html += '<input type="' + ins.valor + '" name="' + ins.id + '" id="' + ins.id + '" value="" class="form-control col-md-7 col-xs-12" placeholder="' + ins.placeholder + '" ' + (ins.required == true ? 'required=""' : '') + '>';
                } else {
                    html += '<select name="' + ins.id + '" id="' + ins.id + '" class="form-control" ' + (ins.required == true ? 'required=""' : '') + '>';
                    for (var j in ins.option) {
                        var o = ins.option[j];
                        html += '<option value="' + o.value + '">' + o.text + '</option>';
                    }
                    html += '</select>';
                }
                html += '</div>';
                html += '</div>';
                $('#' + id).append(html);
            }
        }
    });
    var tabla = {
        eliminarAjax: function (str_json) {
            $.ajax({
                url: urlsC,
                type: 'POST',
                data: {'action': 'elim', 'c': JSON.stringify(str_json)},
                dataType: 'JSON',
                beforeSend: function () {
                    $.isLoading({
                        text: "<strong>Eliminando...</strong>",
                        tpl: '<span class="isloading-wrapper %wrapper%"><i class="fa fa-circle-o-notch fa-2x fa-spin"></i><br>%text%</span>',
                    });
                }
            }).done(function (data) {
                console.log(data)
                if (data.resp) {
                    dataTable.ajax.reload(function () {
                        tabla.metodos();
                        $.isLoading("hide");
                        toastr.options = {
                            progressBar: true,
                            hideDuration: 2000
                        };
                        toastr.success('<b>MENSAJE:</b><br>Dato Eliminado!!');
                    });
                    return;
                } else {
                    $.isLoading("hide");
                    toastr.options = {
                        progressBar: true,
                        hideDuration: 2000
                    };
                    toastr.error((data.error == 'Dato no eliminado' ? '<b>ERROR: </b><br>' + data.error : '<b style="font-size: 12px;">¡¡ERROR!! AL ELIMINAR EL REGISTRO: </b><br><div style="font-size: 10px;">' + data.error + '</div><br><b style="font-size: 14px;">POSIBLES CAUSAS:</b><div style="font-size: 12px;">1.- Otro módulo depende de este registro.<br>2.- Error interno del sistema.</div>'));
                    tabla.metodos();
                }

            }).fail(function () {
                $.isLoading("hide");
                toastr.options = {
                    progressBar: true,
                    hideDuration: 2000
                };
                toastr.error(('Error interno, la tabla depende de una tabla débil :/'));
                tabla.metodos();
            });
            return false;
        },
        metodos: function () {
            this.popConfirm();
        },
        popConfirm: function () {
            //$('.dropdown-2').on({
            //    "click": function (event) {
            //        if ($(event.target).closest('.dropdown-toggle').length) {
            //            $(this).data('closable', true);
            //        } else {
            //            $(this).data('closable', false);
            //        }
            //    },
            //    "hide.bs.dropdown": function (event) {
            //        hide = $(this).data('closable');
            //        $(this).data('closable', true);
            //        return hide;
            //    }
            //});
            $('.data-title').attr('data-menutitle', "Menú de navegación");
        },
        objt: function () {
            var list = [];
            var listLocal = dataTable.rows('.selected').data();
            for (var i = 0; i < listLocal.length; i++) {
                list.push(listLocal[i]);
            }
            return list;
        },
        objtEliminar: function (id, text) {
            var list = [];
            var listDataTable = dataTable.rows().data();
            for (var i = 0; i < listDataTable.length; i++) {
                var data = listDataTable[i];
                if (data[text] == id) {
                    list.push(data)
                    return list;
                }
            }
        },
        crearBoton: function (data) {
            var buttons = [];
            if (data.contextMenu.add) {
                buttons.push(
                        {
                            className: "buttons-crear btn btn-success tooltips", "text": "<i class='fa fa-plus-circle'></i>", "titleAttr": "Agregar registro", action: function (e, dt, node, config) {
                                $('#panel-form').slideDown('slow');
                                $('#panel-listar').slideUp('slow');
                                $('#action').val('add');
                                $('#id_').val('0');
                                $('#caption').html('Crear Registro');
                            }
                        }
                );
            }
            for (var i in data.buttons) {
                var ins = data.buttons[i];
                if (ins == 'print') {
                    if (data.buttons_local) {
                        buttons.push(
                                {
                                    className: "btn btn-default tooltips", text: "<i class='fa fa-print'></i>", "titleAttr": "Imprimir registro", action: function (e, dt, node, config) {
                                        window.print()
                                    }
                                }
                        );
                    } else {
                        buttons.push({extend: "print", className: "btn btn-default tooltips", text: "<i class='fa fa-print'></i>", "titleAttr": "Imprimir registro por defecto",
                            autoPrint: true,
                            exportOptions: {columns: data.colum},
                            customize: function (win) {
                                $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                                $(win.document.body).find('tr:nth-child(odd) td').each(function (index) {
                                    $(this).css('background-color', '#D0D0D0');
                                });
                                $(win.document.body).find('h1').css('text-align', 'center');
                            }
                        });
                    }
                }
                if (ins == 'reload') {
                    buttons.push({className: "btn-actualizar btn btn-default tooltips", text: "<i class='fa fa-refresh'></i>", "titleAttr": "Actualizar tabla", action: function (e, dt, node, config) {
                            dataTable.ajax.reload(function () {
                                $('.data-title').attr('data-menutitle', "Menú de navegación");
                                tabla.metodos();
                            });
                        }});
                }
                if (ins == 'pdf') {
                    buttons.push({extend: "pdfHtml5", className: "btn btn-default tooltips",
                        orientation: 'landscape', pageSize: 'LEGAL', text: "<i class='fa fa-file-pdf-o'></i>", "titleAttr": "Convertir a PDF",
                        exportOptions: {columns: data.colum},
                        customize: function (doc) {
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                width: 90,
                                height: 60,
                                image: this.base64Img
                            });
                        },
                        styles: {
                            tableHeader: {
                                bold: true, fontSize: 11, color: "white", fillColor: "#2d4154", alignment: "center"
                            },
                            tableBodyEven: {},
                            tableBodyOdd: {fillColor: "#f3f3f3"},
                            tableFooter: {bold: true, fontSize: 11, color: "white", fillColor: "#2d4154"},
                            title: {alignment: "center", fontSize: 15},
                            message: {}
                        }
                    });
                }
                if (ins == 'csv') {
                    buttons.push({extend: "csvHtml5", className: "btn btn-default tooltips", text: "<i class='fa fa-file-text-o'></i>", "titleAttr": "Convertir a CSV",
                        exportOptions: {columns: data.colum}
                    });
                }
                if (ins == 'excel') {
                    buttons.push({extend: "excelHtml5", className: "btn btn-default tooltips", text: "<i class='fa fa-file-excel-o'></i>", "titleAttr": "Convertir a EXCEL",
                        exportOptions: {columns: data.colum}
                    });
                }
                if (ins != 'pdf' && ins != 'add' && ins != 'reload' && ins != 'print' && ins != 'excel' && ins != 'csv') {
                    buttons.push({className: "btn btn-primary tooltips", text: ins,
                        action: function (e, dt, node, config) {

                        }
                    });
                }
            }
            return buttons;
        },
        columns: function (data) {
            var listColumn = [];//defaultContent
            listColumn.push({"data": function (d, t, f) {
                    return '';
                }});
            for (var i in data.ajax.resp) {
                listColumn.push(data.ajax.resp[i]);
            }
            /*
             listColumn.push(
             {
             "data": data.id, "render": function (data_, type, full) {
             var str = '<div class="btn-group dropdown-2">'
             str += ''
             str += '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'
             str += '<span class="fa fa-chevron-down text-danger"></span>'
             str += '<span class="sr-only text-right">Toggle Dropdown</span>'
             str += '</button>'
             str += '<ul class="dropdown-menu pull-right" role="menu">'
             //str += '<li class="dropdown-header">Opciones</li>';
             str += '<li><a href="#demo-form2" ' + (data.contextMenu.edit.estado == true ? 'rel="action" data-json=\'{"action": "editar","id": "' + data_ + '"}\'' : 'class="dropdown-2-disabled"') + '><i class="fa fa-edit fa-pull-right ' + (data.contextMenu.edit.estado == false ? 'class="dropdown-2-disabled' : '') + ' text-info" style="padding-top:3px"> </i><div style="padding-left: 8px">Editar</div></a></li>'
             str += '<li><a href="#demo-form2" ' + (data.contextMenu.elim == true ? ' rel="action" data-json=\'{"action": "eliminar","id": "' + data_ + '"}\'' : 'class="dropdown-2-disabled"') + '><i class="fa fa-trash-o fa-pull-right ' + (data.contextMenu.elim == false ? 'class="dropdown-2-disabled' : '') + ' text-danger" style="padding-top:3px"> </i><i class="fa fa-caret-left"></i> Eliminar</a></li>'
             str += '</ul>'
             str += '</div>';
             str += '';
             str += '';
             return '<div class="file-footer-buttons" title="Editar o eliminar">' + str + '</div>';
             },
             className: 'middle'
             }
             );*/
            return listColumn;
        },
        españolDataTable: function () {
            return {
                "select": {
                    "rows": {
                        "_": "<code>%d filas seleccionadas.</code>",
                        //"0": "<code>Clic para seleccionar filas.</code>",
                        "1": "<code>1 fila seleccionada.</code>"
                    }
                },
                "sSearch": "<span class='fa fa-search'></span> ",
                "sZeroRecords": "No se encontraron resultados",
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ":Activar para ordenar la columna de manera descendente"
                },
                "oPaginate": {"sFirst": "Primero", "sLast": "Último", "sNext": "<span class='fa fa-chevron-right'></span>", "sPrevious": "<span class='fa fa-chevron-left'></span>"},
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrando _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ <br> <b>Total: </b> _MAX_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros<br>",
                "sInfoFiltered": "(de un total de _MAX_ registros)",
                "sInfoPostFix": ""
            };
        },
        completarDatos: function (data) {
            var numColumn = 0;
            for (var i in data.thead) {
                numColumn = i;
            }
            $('.tooltips').tooltip({trigger: 'hover'});
            tabla.metodos();
            $('#tabla').css('width', '100%');
            $('#tabla').css('max-width', '100%');
            $('#tabla').css('margin-bottom', '20px');
            $('#tabla > thead > tr > th.select-checkbox').css({'min-width': '15px', 'max-width': '15px', 'width': '15px'});
            $('#tabla > thead > tr > th:nth-child(' + (parseInt(numColumn) + 3) + ')').css({'min-width': '50px', 'max-width': '50px', 'width': '50px'});
            $('#tabla_wrapper > div.dt-buttons a').removeClass('dt-button buttons-html5');
            $('#tabla_filter > label > input').attr({
                placeholder: "Buscar en la tabla.."
            });
            $('#marcar_todo').on('click', function () {
                if ($(this).is(':checked')) {
                    dataTable.rows().select();
                } else {
                    dataTable.rows().deselect();
                }
            });
            $('#tdetalle > tr > td.select-checkbox').on('click', function () {
                if (parseInt(tabla.objt().length) == 1) {
                    $('#marcar_todo').prop('checked', false);
                }
            });
            $(".fakeloader").fadeOut();
            //$('#tabla_wrapper > div.dt-buttons > a.buttons-crear').remove();
        },
        contextMenu: function (data) {
            if (data.contextMenu.visible) {
                $.contextMenu({
                    selector: '#tdetalle',
                    autoHide: true,
                    className: 'data-title',
                    animation: {duration: 900, show: 'fadeIn', hide: 'fadeOut'},
                    events: {
                        show: function (options) {
                            //console.log(this)
                        }
                    },
                    items: {
                        "sep1": "---------",
                        "add": {
                            name: "Agregar",
                            icon: "fa-plus",
                            //accesskey: "s",
                            disabled: function (key, opt) {
                                if (data.contextMenu.add) {
                                    return false;
                                } else {
                                    return true;
                                }
                            },
                            callback: function (key, options) {
                                $('#panel-form').slideDown('slow');
                                $('#panel-listar').slideUp('slow');
                                $('#accion_form').html('Crear ');
                                $('#action').val('add');
                            }
                        },
                        "sep2": "---------",
                        "edit": {name: "Editar", icon: "fa-edit", accesskey: "e",
                            disabled: function (key, opt) {
                                if (data.contextMenu.edit.estado) {
                                    if (tabla.objt().length == 1) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                } else {
                                    return true;
                                }

                            },
                            callback: data.contextMenu.edit.callback
                        },
                        "sep3": "---------",
                        "delete": {
                            name: "Eliminar", icon: "fa-trash-o",
                            disabled: function (key, opt) {
                                if (data.contextMenu.elim) {
                                    var t = tabla.objt().length;
                                    if (t > 0) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                } else {
                                    return true;
                                }
                            },
                            callback: function (key, options) {
                                var list = tabla.objt();
                                var title = '¿Desea eliminar ' + (list.length == 1 ? 'el registro' : 'los ' + list.length + ' registros') + ' ?';
                                $.confirm({
                                    //icon: 'fa fa-warning',
                                    theme: 'bootstrap',
                                    type: 'red',
                                    typeAnimated: true,
                                    animation: 'zoom',
                                    title: 'Confirmar acción!',
                                    content: title,
                                    buttons: {
                                        confirm: {
                                            text: '<i class="fa fa-trash-o"></i> Eliminar',
                                            btnClass: 'btn-danger',
                                            keys: ['enter'],
                                            action: function () {
                                                tabla.eliminarAjax(list);
                                            }
                                        },
                                        cancel: {
                                            text: 'Cancelar',
                                            action: function () {
                                                return true;
                                            }
                                        }
                                    }
                                });
                            }
                        },
                        "sep4": "---------",
                        "ordenar": {
                            name: "Ordenar", icon: "fa-list-ol",
                            callback: function () {
                                dataTable.column('2:visible').order('asc').draw();
                            }
                        },
                        "sep5": "---------",
                        "actualizar": {
                            name: "Actualizar", icon: "fa-refresh",
                            callback: function () {
                                dataTable.ajax.reload(function () {
                                    $('.data-title').attr('data-menutitle', "Menú de navegación");
                                    tabla.metodos();
                                });
                            }
                        },
                        "sep6": "---------",
                        "print": {
                            name: "Impimir", icon: "fa-print",
                            callback: function () {
                                window.print();
                            }
                        }
                    }
                });
                return true;
            } else {
                return false;
            }
        },
        dibujarTabla: function (data) {
            var container = data.container;
            var html = '';
            var thead = data.thead;
            html += '<table id="tabla" class="table ' + ((typeof (data.tabla.className) == 'undefined') ? 'table-striped table-bordered jambo_table' : data.tabla.className) + '">';
            html += '<thead>';
            html += '<tr>';
            html += '<th class="text-center"></th>';
            for (var i in thead) {
                var t = thead[i];
                html += '<th>' + t + '</th>';
            }
            //html += '<th>Acción</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody id="tdetalle" align="center"></tbody>';
            html += '</table>';
            $('#' + container).html(html);
            return true;
        }
    };
})(jQuery, window, document);