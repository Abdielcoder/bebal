//		$(document).ready(function(){
//		load(1);
//		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_principal.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="img/ajax-loader.gif"> Cargando...');
				 $(".outer_div").css('opacity', '0.5');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$(".outer_div").css('opacity', '1');
					
					// Inicializar eventos de botones modales para la nueva interfaz
					inicializarEventosModal();
				},
				error: function(xhr, status, error) {
					$('#loader').html('Error al cargar los datos: ' + error);
					console.error("Error en la carga: ", error);
					$(".outer_div").css('opacity', '1');
				},
				complete: function() {
					setTimeout(function() {
						$('#loader').html('');
					}, 1000);
				}
			})
		}

		// Función para inicializar eventos de botones modales
		function inicializarEventosModal() {
			// Botones de mapa
			$('[id^="myBtn2_"]').each(function() {
				var id = $(this).attr('id').split('_')[1];
				$(this).off('click').on('click', function() {
					$("#myModal_Emergente2_" + id).css('display', 'block');
				});
			});

			// Cerrar modal de mapa
			$('[class^="close_Emergente2_"]').each(function() {
				var id = $(this).attr('class').split('_')[2];
				$(this).off('click').on('click', function() {
					$("#myModal_Emergente2_" + id).css('display', 'none');
				});
			});

			// Cerrar modal al hacer clic fuera del contenido
			$('[id^="myModal_Emergente2_"]').each(function() {
				var id = $(this).attr('id').split('_')[2];
				$(this).off('click').on('click', function(event) {
					if (event.target == this) {
						$(this).css('display', 'none');
					}
				});
			});
		}

		// Inicializar carga al cargar la página
		$(document).ready(function(){
			load(1);
			
			// Si después de 5 segundos sigue cargando, intentar recargar automáticamente
			setTimeout(function() {
				if ($(".outer_div").is(':empty')) {
					console.log("Recargando automáticamente...");
					load(1);
				}
			}, 5000);
		});

		function eliminar (id)
		{
		var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el Registro de la Valla ?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_principal.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		
	
$( "#guardar_trabajo" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_trabajo.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_categoria" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_categoria.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	
	$('#myModal2').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var nombre = button.data('nombre') 
	  var descripcion = button.data('descripcion') 
	  var id = button.data('id') 
	  var modal = $(this)
	  modal.find('.modal-body #mod_nombre').val(nombre)
	  modal.find('.modal-body #mod_descripcion').val(descripcion) 
	  modal.find('.modal-body #mod_id').val(id)
	})
		

