$(function() {
	$(document).on("click", "a#adulto_list", function(){ getAdultoList(this); });	
	$(document).on("click", "a#create_adulto_form", function(){ getCreateForm(this); });
	$(document).on("click", "button#add_adulto", function(){ addAdulto(this); });
	$(document).on("click", "a.delete_confirm", function(){ deleteConfirmation(this); });
	$(document).on("click", "button.delete", function(){ deleteAdulto(this); });
	$(document).on("dblclick", "td.edit", function(){ makeEditable(this); });
	$(document).on("blur", "input#editbox", function(){ removeEditable(this) });
	$(document).on("click", "a#search_adulto_form", function(){ getBuscarForm(this); });
	$(document).on("click", "button#search_adulto", function(){ searchAdulto(this); });
});

function removeEditable(element) { 
	
	$('#indicator').show();
	
	var Adulto = new Object();
	Adulto.id = $('.current').attr('adulto_id');		
	Adulto.field = $('.current').attr('field');
	Adulto.newvalue = $(element).val();
	
	var adultoJson = JSON.stringify(Adulto);
	
	$.post('Adulto.php',
		{
			action: 'update_field_data',			
			adulto: adultoJson
		},
		function(data, textStatus) {
			$('td.current').html($(element).val());
			$('.current').removeClass('current');
			$('#indicator').hide();			
		}, 
		"json"		
	);	
}

function makeEditable(element) { 
	$(element).html('<input id="editbox" size="'+  $(element).text().length +'" type="text" value="'+ $(element).text() +'">');
	$('#editbox').focus();
	$(element).addClass('current'); 
}

function deleteConfirmation(element) {	
	$("#delete_confirm_modal").modal("show");
	$("#delete_confirm_modal input#adulto_id").val($(element).attr('adulto_id'));
}

function deleteAdulto(element) {	
	
	var Adulto = new Object();
	Adulto.id = $("#delete_confirm_modal input#adulto_id").val();
	
	var adultoJson = JSON.stringify(Adulto);
	
	$.post('Adulto.php',
		{
			action: 'delete_adulto',
			adulto: adultoJson
		},
		function(data, textStatus) {
			getAdultoList(element);
			$("#delete_confirm_modal").modal("hide");
		}, 
		"json"		
	);	
}

function getAdultoList(element) {
	
	$('#indicator').show();
	
	$.post('Adulto.php',
		{
			action: 'get_adultos'				
		},
		function(data, textStatus) {
			renderAdultoList(data);
			$('#indicator').hide();
		}, 
		"json"		
	);
}

function renderAdultoList(jsonData) {
	
	var table = '<table width="600" cellpadding="5" class="table table-hover table-bordered"><thead><tr><th scope="col">SKU</th><th scope="col">PRODUCTO</th><th scope="col">PRESENTACION</th><th scope="col">PESO</th><th scope="col">PORCION</th><th scope="col"></th></tr></thead><tbody>';

	$.each( jsonData, function( index, adulto){     
		table += '<tr>';
		table += '<td class="edit" field="sku" adulto_id="'+adulto.id+'">'+adulto.sku+'</td>';
		table += '<td class="edit" field="producto" adulto_id="'+adulto.id+'">'+adulto.producto+'</td>';
		table += '<td class="edit" field="presentacion" adulto_id="'+adulto.id+'">'+adulto.presentacion+'</td>';
		table += '<td class="edit" field="peso" adulto_id="'+adulto.id+'">'+adulto.peso+'</td>';
		table += '<td class="edit" field="porcion" adulto_id="'+adulto.id+'">'+adulto.porcion+'</td>';
		table += '<td><a href="javascript:void(0);" adulto_id="'+adulto.id+'" class="delete_confirm btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
		table += '</tr>';
    });
	
	table += '</tbody></table>';
	
	$('div#content').html(table);
}

function addAdulto(element) {	
	
	$('#indicator').show();
	
	var Adulto = new Object();
	Adulto.sku = $('input#sku').val();
	Adulto.producto = $('input#producto').val();
	Adulto.presentacion = $('input#presentacion').val();
	Adulto.peso = $('input#peso').val();
	Adulto.porcion = $('input#porcion').val();
	
	var adultoJson = JSON.stringify(Adulto);
	
	$.post('Adulto.php',
		{
			action: 'add_adulto',
			adulto: adultoJson
		},
		function(data, textStatus) {
			getAdultoList(element);
			$('#indicator').hide();
		}, 
		"json"		
	);
}

function getCreateForm(element) {
	var form = '<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="icon-home icon-black"></i> SKU</span>';
		form +=	'<input type="text" id="sku" name="sku" value="" class="input-xlarge" />';		
		form +=	'</div><br/><br/>';

		form +=	'<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="icon-home icon-black"></i> PRODUCTO</span>';
		form +=	'<input type="text" id="producto" name="producto" value="" class="input-xlarge" />';
		form +=	'</div><br/><br/>';
				
		form +=	'<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="icon-home icon-black"></i> PRESENTACION</span>';
		form +=	'<input type="text" id="presentacion" name="presentacion" value="" class="input-xlarge" />';
		form +=	'</div><br/><br/>';
				
		form +=	'<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="icon-home icon-black"></i> PESO</span>';
		form +=	'<input type="text" id="peso" name="peso" class="input-xlarge"/>';
		form +=	'</div><br/><br/>';

		form +=	'<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="icon-home icon-black"></i> PORCION</span>';
		form +=	'<input type="text" id="porcion" name="porcion" class="input-xlarge"/>';
		form +=	'</div><br/><br/>';

		form +=	'<div class="control-group">';
		form +=	'<div class="">';		
		form +=	'<button type="button" id="add_adulto" class="btn btn-primary"><i class="icon-ok icon-white"></i> Agregar Producto a Catalogo</button>';
		form +=	'</div>';
		form +=	'</div>';
		
		$('div#content').html(form);
}

function getBuscarForm(element) {
	var form = '<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="icon-home icon-black"></i> SKU</span>';
		form +=	'<input type="text" id="sku" name="sku" value="" class="input-xlarge" />';		
		form +=	'</div><br/><br/>';

		form +=	'<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="icon-home icon-black"></i> PESO</span>';
		form +=	'<input type="text" id="peso" name="peso" class="input-xlarge"/>';
		form +=	'</div><br/><br/>';		

		form +=	'<div class="control-group">';
		form +=	'<div class="">';		
		form +=	'<button type="button" id="search_adulto" class="btn btn-default"><i class="icon-search icon-white"></i> Buscar Producto</button>';
		form +=	'</div>';
		form +=	'</div>';
		
		$('div#content').html(form);
}

function searchAdulto(element) {	
	
	$('#indicator').show();
	
	var Adulto = new Object();
	Adulto.sku = $('input#sku').val();
	Adulto.peso = $('input#peso').val();	
	
	var adultoJson = JSON.stringify(Adulto);
	
	$.get('Adulto.php',
		{
			action: 'search_adulto',
			adulto: adultoJson
		},
		function(data, textStatus) {
			renderAdultoList(data);
			$('#indicator').hide();
		}, 
		"json"		
	);
}