<div class="section large">
	<h1>Menus</h1>
</div>
<div class="row two-column first-is-thin">
	<div class="column">
		<h2>Create a new menu</h2>
		<div>
			<form>
				<button type="submit" class="tiny float-right">Create</button>
			</form>
		</div>
		<h2>Add elements</h2>
		<div class="accordions-group">
			<button class="accordion">Pages</button>
			<div class="panel accordion">
				<form>
					<div class="for-menus">
						<?php get_content_for_menus('page'); ?>
					</div>
					<button type="submit" class="tiny float-right">Add to menu</button>
				</form>
			</div>
			
			<button class="accordion">Posts</button>
			<div class="panel accordion">
				<form>
					<div class="for-menus">
						<?php get_content_for_menus('post'); ?>
					</div>
					<button type="submit" class="tiny float-right">Add to menu</button>
				</form>
			</div>

			<button class="accordion">Custom links</button>
			<div class="panel accordion">
				<form>
					<div class="for-menus">
						<?php //get_links_for_menus('link'); ?>
					</div>
					<button type="submit" class="tiny float-right">Add to menu</button>
				</form>
			</div>

			<button class="accordion">Classes</button>
			<div class="panel accordion">
				<form>
					<div class="for-menus">
						<?php get_terms_for_menus('class'); ?>
					</div>
					<button type="submit" class="tiny float-right">Add to menu</button>
				</form>
			</div>
		</div>
	</div>
	<div class="column">
		<h2>Organise your menu</h2>
			<div class="accordions-group">
				<?php get_menus(); ?>
			</div>
	</div>
</div>