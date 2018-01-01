<?php
/* 
	<script type="text/javascript">
		$(function(){
			var a_valueElement = $('#a_value');

			function incrementValue(e){
				if(parseInt(a_valueElement.text()) == 1 && e.data.increment < 0 ){
					// $(this).attr('disabled', true);
					alert("Sorry value count Can't be zero...");
				}
				else if(parseInt(a_valueElement.text()) == 1){
					a_valueElement.text(Math.max(parseInt(a_valueElement.text()) + e.data.increment, 0));
					$('#a_word').text('Adults');
				}
				else if(parseInt(a_valueElement.text()) > 1){
					a_valueElement.text(Math.max(parseInt(a_valueElement.text()) + e.data.increment, 0));
					$('#a_word').text('Adult');
				}
				return false;
			}

			$('#a_plus').bind('click', {increment: 1}, incrementValue);
			$('#a_minus').bind('click', {increment: -1}, incrementValue);
			


		});
	</script>

*/

?>