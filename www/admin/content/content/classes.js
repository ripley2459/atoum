/* $(document).on('click', '#add_class', function(){
	var name = $('#name').val();
	var slug = $('#slug').val();
	var parent = $('#parent').val();
	var description = $('#description').val();
	$.ajax({
		url: 'classes.php',
		type: 'POST',
		data: {
			'add': 1,
			'name': name,
			'slug': comment,
			'parent_id' : parent,
			'description' : description,
		},
			success: function(response){
				$('#name').val('');
				$('#slug').val('');
				$('#parent').val('');
				$('#name').val('');
			}
	});
}); */