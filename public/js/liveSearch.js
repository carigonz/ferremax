$(document).ready(function () {
	fetchData();
	$('#query').keyup( function(){
		let query = $(this).val();
		fetchData(query);
		//console.log(query);
	});
	function fetchData(query = '')
	{
		$.ajaxSetup({
			headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url:'{{ route('search.action') }}',
			method: 'GET',
			data: {query:query},
			dataType: 'json'
		}).done( function(data){
				$('tbody').html(data.table_data);
				$('#total_records').text(data.total_data);
				console.log(data);
			}
		).fail( function(data){
			console.log(data.responseJSON);
			console.log('pasaron cosas');
		});
	}
});