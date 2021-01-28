<div class="has-right-menu">
	<div class="section large">
		<h1>Editor</h1>
		<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
		<div id="editor">
		</div>
	</div>
</div>

<nav class="side-menu right">
	<div class="side-menu-content">
		<div>
			<div class="accordion full">Pages</div>
			<div class="accordion-panel">
				<h1>Editor</h1>
				<h1>Editor</h1>
			</div>
		</div>
		<div>
			<div class="accordion full">Classes</div>
			<div class="accordion-panel">
				<h1>Editor</h1>
				<h1>Editor</h1>
			</div>
		</div>
		<button type="submit" value="Submit" class="full float-right">Add</button>
	</div>
</nav>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>