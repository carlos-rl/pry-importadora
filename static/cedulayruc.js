(function ($) {
    $.extend({
        cedula: function (cedula) {
            if (typeof (cedula) === 'string' && cedula.length === 10 && /^\d+$/.test(cedula)) {
                var digitos = cedula.split('').map(Number);
                var codigo_provincia = digitos[0] * 10 + digitos[1];

                if (codigo_provincia >= 1 && (codigo_provincia <= 24 || codigo_provincia === 30) && digitos[2] < 6) {
                    var digito_verificador = digitos.pop();

                    var digito_calculado = digitos.reduce(
                            function (valorPrevio, valorActual, indice) {
                                return valorPrevio - (valorActual * (2 - indice % 2)) % 9 - (valorActual === 9) * 9;
                            }, 1000) % 10;
                    return digito_calculado === digito_verificador;
                }
            }
            return false;
        },
        ruc: function (ruc) {
            var numero = ruc;
            var suma = 0;
            var residuo = 0;
            var pri = false;
            var pub = false;
            var nat = false;
            var numeroProvincias = 22;
            var modulo = 11;

            /* Verifico que el ruc no contenga letras */
            var ok = 1;

            /* Aqui almacenamos los digitos de la cedula en variables. */
            d1 = numero.substr(0, 1);
            d2 = numero.substr(1, 1);
            d3 = numero.substr(2, 1);
            d4 = numero.substr(3, 1);
            d5 = numero.substr(4, 1);
            d6 = numero.substr(5, 1);
            d7 = numero.substr(6, 1);
            d8 = numero.substr(7, 1);
            d9 = numero.substr(8, 1);
            d10 = numero.substr(9, 1);

            /* El tercer digito es: */
            /* 9 para sociedades privadas y extranjeros */
            /* 6 para sociedades publicas */
            /* menor que 6 (0,1,2,3,4,5) para personas naturales */

            if (d3 == 7 || d3 == 8) {
                //alert('El tercer dígito ingresado es inválido');
                return false;
            }

            /* Solo para personas naturales (modulo 10) */
            if (d3 < 6) {
                nat = true;
                p1 = d1 * 2;
                if (p1 >= 10)
                    p1 -= 9;
                p2 = d2 * 1;
                if (p2 >= 10)
                    p2 -= 9;
                p3 = d3 * 2;
                if (p3 >= 10)
                    p3 -= 9;
                p4 = d4 * 1;
                if (p4 >= 10)
                    p4 -= 9;
                p5 = d5 * 2;
                if (p5 >= 10)
                    p5 -= 9;
                p6 = d6 * 1;
                if (p6 >= 10)
                    p6 -= 9;
                p7 = d7 * 2;
                if (p7 >= 10)
                    p7 -= 9;
                p8 = d8 * 1;
                if (p8 >= 10)
                    p8 -= 9;
                p9 = d9 * 2;
                if (p9 >= 10)
                    p9 -= 9;
                modulo = 10;
            }

            /* Solo para sociedades publicas (modulo 11) */
            /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
            else if (d3 == 6) {
                pub = true;
                p1 = d1 * 3;
                p2 = d2 * 2;
                p3 = d3 * 7;
                p4 = d4 * 6;
                p5 = d5 * 5;
                p6 = d6 * 4;
                p7 = d7 * 3;
                p8 = d8 * 2;
                p9 = 0;
            }

            /* Solo para entidades privadas (modulo 11) */
            else if (d3 == 9) {
                pri = true;
                p1 = d1 * 4;
                p2 = d2 * 3;
                p3 = d3 * 2;
                p4 = d4 * 7;
                p5 = d5 * 6;
                p6 = d6 * 5;
                p7 = d7 * 4;
                p8 = d8 * 3;
                p9 = d9 * 2;
            }

            suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
            residuo = suma % modulo;

            /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
            digitoVerificador = residuo == 0 ? 0 : modulo - residuo;

            /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
            if (pub == true) {
                if (digitoVerificador != d9) {
                    // alert('El ruc de la empresa del sector público es incorrecto.');
                    return false;
                }
                /* El ruc de las empresas del sector publico terminan con 0001*/
                if (numero.substr(9, 4) != '0001') {
                    // alert('El ruc de la empresa del sector público debe terminar con 0001');
                    return false;
                }
            } else if (pri == true) {
                if (digitoVerificador != d10) {
                    //alert('El ruc de la empresa del sector privado es incorrecto.');
                    return false;
                }
                if (numero.substr(10, 3) != '001') {
                    //alert('El ruc de la empresa del sector privado debe terminar con 001');
                    return false;
                }
            } else if (nat == true) {
                if (digitoVerificador != d10) {
                    //alert('El número de cédula de la persona natural es incorrecto.');
                    return false;
                }
                if (numero.length > 10 && numero.substr(10, 3) != '001') {
                    //alert('El ruc de la persona natural debe terminar con 001');
                    return false;
                }
            }
            return true;
        },
		mHTML:function(data){
				var options = $.extend({}, this.defaultOptions_menuHtml, data);
				var html = '<div class="dropdown">';
				html += '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">';
				html += 'Acción <i class="fa fa-caret-down"></i></button>';
				html += '<ul class="dropdown-menu dropdown-menu-left">';
				html += '<li class="dropdown-header">'+options.título_mantenimiento+'</li> ';
				html += '<li>';
				html += (options.crear === 1 ? '<a title="Crear '+options.mantenimiento+'" class="" rel="'+options.rel+'" data-json=\'{"id":"' + options.id + '","action":"add","json_":' + JSON.stringify(options.json) + '}\'>Crear <i class="fa fa-plus pull-right"></i></a>' : '');
				html += '</li>';
				html += '<li>';
				html += (options.editar === 1 ? '<a title="Editar '+options.mantenimiento+'" class="" rel="'+options.rel+'" data-json=\'{"id":"' + options.id + '","action":"edit","json_":' + JSON.stringify(options.json) + '}\'>Editar <i class="fa fa-edit pull-right"></i></a>' : '');
				html += '</li>';
				html += '<li>';
				html += (options.eliminar === 1 ? '<a title="Eliminar '+options.mantenimiento+'" class="" rel="'+options.rel+'" data-json=\'{"id":"' + options.id + '","action":"elim"}\'>Eliminar <i class="fa fa-trash-o pull-right"></i></a>' : '');
				html += '</li>';
				
				for(var i in options.item){
					var o = options.item[i];
					html += '<li>';
					html += '<a title="'+o.title+'" class="" rel="'+options.rel+'" data-json=\'{"id":"' + options.id + '","action":"'+o.action+'","json_":' + JSON.stringify(options.json) + '}\'>'+o.title_btn+'</a>';
					html += '</li>';
				}
				
				html += '</ul>';
				html += '</div>';
				return html;
			},
			defaultOptions_menuHtml: {
				rel:'action',
				editar: 1,
				crear: 1,
				eliminar:1,
				id: 0,
				json: [],
				título_mantenimiento: '',
				mantenimiento:'',
				// item:[{
					// title: '',
					// title_btn: 'Editar<i class="fa fa-edit pull-right"></i>',
					// action: ''
				// }]
			}
    });
})(jQuery);