<script>
	{{--var csrf_token = $('[name="csrf_token"]').attr('content');--}}
	{{-- Select2 --}}

	$(document).ready(function() {
		$(".select2_multiple").select2({
			maximumSelectionLength:10,
			placeholder: "Assign To",
			allowClear: true,
			width:'100%'
		});

	});

	$(window).load(function() {
		loopHotelDetail();
	});
	{{-- /Select2 --}}


	$(document).on('ifChanged', 'input', function() {
		var type = $(this).attr('data-type');
		var isChecked = $(this).is(':checked');
		/*console.log(isChecked);*/
		if (type == 'todo') {
			var toDoId = $(this).attr('data-id');
			if (isChecked) {
				$('#menu_todo_text_'+toDoId).addClass('line-through');
			}else{
				$('#menu_todo_text_'+toDoId).removeClass('line-through');
			}

			changeStatusTodo(toDoId);

			setTimeout( function(){ 
				refreashTodo('#menu_todo');
				/*Do something after 1 second */
			}  , 5000 );
		}
	});



	{{-- Saving to do --}}
	$(document).on('click', '.btn-to-do', function(){
		var to_do_select = $('#to_do_select').val();
		var to_do_text = $('#to_do_text').val();

		var data = {
			"_token" : csrf_token,
			"toDoText" : to_do_text,
			"toDoSelect" : to_do_select
		};

		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo') }}",
			data : data,
		});

		setTimeout( function(){ 
			refreashTodo('#menu_todo');
			/*Do something after 1 second */
		}  , 1000 );

		$('#to_do_text').val('');
		$('.btn-to-do-close').click();
	});
	{{-- /Saving to do --}}



	$(document).on('click', '.remove-to-do',function(){
		var toDoIndex = $(this).attr('data-index');
		removeTodo(toDoIndex);

		setTimeout( function(){ 
			refreashTodo('#menu_todo');
			/*Do something after 1 second */
		}  , 1000 );
	});




	function refreashLeadBox() {
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/enquiry/pending') }}",
			data : { "_token" : csrf_token },
			success: function(response, textStatus, xhr) {
				var response = JSON.parse(response);
				var leadCount = response.length ? response.length : '';
				
				$('#menu_lead_box_count').html(leadCount);

				var html = '';
				$('#menu_lead_box').empty();
				$('#menu_lead_box').html('<li><h2>Lead Box</h2></li>');
				$.each(response, function(i,v){
					elemId = i;
					html = makeLeadBoxHtml(i,v);
					$('#menu_lead_box').append(html);
				});
			},
		});
	}


	function makeLeadBoxHtml(i,Obj) {
		<?php
			$html = 'return \'<li>
					<a href="'.url('dashboard/package/route').'/\'+Obj.token+\'">
						<span>
							<span><b class="font-size-15">\'+Obj.fullname+\'</b></span>
							<span class="time">\'+Obj.created_at+\'</span>
						</span>
						<div><b>Mobile : </b>\'+Obj.mobile+\'</div>
						<span class="message"><b>Message : </b>\'+Obj.note+\'</span>
					</a>
				</li>\'';
			$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
			echo $html;
		?>
	}


	function refreashTodo(toDoId) {
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo/all/json') }}",
			data : { "_token" : csrf_token },
			success: function(response, textStatus, xhr) {
					response =  JSON.parse(response);
					var html = makeTodoHtml(response);
					if (response.length) {
						$('#todos_count').text(response.length);
					}
					$(toDoId).html(html);
					$('#menu_todo').find('input').iCheck({
						checkboxClass: 'icheckbox_flat-green'
					});
				},
		});
	}

	function makeTodoHtml(todos) {
		var html = '<li><h2>To-do Lists</h2></li>';
		$.each(todos, function(todokey, todo) {
			var toDoId = todo.id;
			var toDoText = todo.text;
			var toDoStatus = todo.status;
			var lineThrough = toDoStatus == 'active' ? '' : 'line-through';
			var isChecked = toDoStatus == 'active' ? '' : 'checked="checked"';

			<?php 
				$todoJsHtml = view('b2b.protected.dashboard.partials.script_partials.todo')
											->render();
				$todoJsHtml = trimHtml($todoJsHtml);
			?>
			html += '{!! $todoJsHtml !!}';
		});
		html += '<li><div class="text-center"><a href="{{ url('dashboard/todo') }}"><strong>See All Todo</strong><i class="fa fa-angle-right"></i></a></div></li>';
		return html;
	}

	function removeTodo(id) {
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo/remove') }}",
			data : { "_token" : csrf_token, "id" : id }
		});
	}

	function changeStatusTodo(id) {
		var data = { "_token" : csrf_token, "id" : id };

		$.ajax({
			type : "post",
			url : "{{ url('dashboard/todo/status') }}",
			data : data,
		});
	}



	function loopHotelDetail() {
		$.ajax({
			type : "get",
			url : "{{ url('a/l/htdetail') }}"
		});
	}



	function refreashTrack(){
		$.ajax({
			type : "post",
			url : "{{ url('dashboard/package/track/json') }}",
			data : { "_token" : csrf_token},
			success: function(response, textStatus, xhr) {
				response =  JSON.parse(response);
				$('#menu_track').empty();
				$('#menu_track').append('<li><h2>Package Status</h2></li>');
				var trackCount = response.length ? response.length : ''; 
				$('#menu_track_count').text(trackCount);
				$.each(response, function(trackKey, track) {
					<?php 
						$trackJsHtml = view('b2b.protected.dashboard.partials.script_partials.track')->render();
						$trackJsHtml = trimHtml($trackJsHtml);
					?>
					$('#menu_track').append('{!! $trackJsHtml !!}');
				});
				$('#menu_track').append('<li><div class="text-center"><a href="{{ route('packages.track') }}"><strong>See All Track</strong><i class="fa fa-angle-right"></i></a></div></li>');
			}
		});
	}



	var vTimeOut;

	$(function() {
		vTimeOut= setInterval(refreashLeadBox, 20000);
		vTimeOut= setInterval(refreashTrack, 20000);
	});




	function showWaitingLogo() {
		var html = '<style>#logo{ top: 32vh; left: 42.5%; position: fixed; font-size: 210px !important; z-index: 100; } #fgfpreloader { top: 27vh; left: 40%; font-size: 5px; border-radius: 50%; width: 250px; height: 250px; position: fixed; text-indent: -9999em; border-top: 1.1em solid rgba(255,255,128, 0.2); border-right: 1.1em solid rgba(255,255,128, 0.2); border-bottom: 1.1em solid rgba(255,255,128, 0.2); border-left: 1.1em solid #FFD700; z-index: 100; -webkit-transform: translateZ(0); -ms-transform: translateZ(0); transform: translateZ(0); -webkit-animation: load8 1.1s infinite linear; animation: load8 1.1s infinite linear; } @-webkit-keyframes load8 { 0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); } 100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); } } @keyframes load8 { 0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); } 100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); } }</style><div id="showWaitingLogo"><div id="fgfpreloader" class="fixed-top"></div><i id="logo" class="s-icon-fgf font-big fixed-top"></i></div>';
		$('body').prepend(html);
	}

	function hideWaitingLogo() {
		$('#showWaitingLogo').remove();
	}


	function showSpinIcon() {
		$('#fa_def_filter_icon').addClass('hide');
		$('#fa_spin_filter_icon').removeClass('hide');
	}

	function hideSpinIcon() {
		$('#fa_spin_filter_icon').addClass('hide');
		$('#fa_def_filter_icon').removeClass('hide');
	}

</script>