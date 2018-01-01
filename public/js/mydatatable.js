function datatableWithSearch(table, option = {}, data = {}) {
	var params = {
				"pageLength": 50,
				"bPaginate" : false
			};
	
	url = isset(data, 'url') ? data.url : '';
	method = isset(data, 'method') ? data.method : 'GET';
	inputs = isset(data, 'inputs') ? data.inputs : '';
	append = isset(data, 'append') ? data.append : '';
	prepend = isset(data, 'prepend') ? data.prepend : '';

	$.extend(params, option);

	$(table).dataTable(params);

	$("#datatable_filter").addClass('width-100-p');
	$("#datatable_filter > label").prepend(prepend);
	$("#datatable_filter > label").append(append+'<button id="btn_search" class="btn btn-default btn-sm m-top-5"><i class="fa fa-search"></i><form method="'+method+'" action="'+url+'" name="serach_form" hidden>'+inputs+'<input id="input_search" type="hidden" name="search" value=""></form></button>');
}

$(document).on('click', '#btn_search', function () {
	var search = $(this).closest('#datatable_filter')
												.find('input[type="search"]').val();

	$(this).find('#input_search').val(search);
	var serachSorm = $(this).find('[name="serach_form"]');
	serachSorm.submit();
});