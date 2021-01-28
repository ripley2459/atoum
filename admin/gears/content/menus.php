<div class="section large">
	<h1>Menus</h1>
	<div class="row two-column first-is-thin">

		<div class="column">
			<h2>Create a new menu</h2>
			<div>
				<form>
					<input type="text" placeholder="Menu name" class="full"><button type="submit" class="float-right">Create</button>
				</form>
			</div>

			<h2>Add elements</h2>
			<div class="accordions-group">
				<div>
					<div class="accordion">Pages<i class="icon"></i></div>
					<div class="accordion-panel">
					<form>
						<?php get_content_for_menus('page'); ?>
						<button type="submit" class="tiny float-right">Add to menu</button>
					</form>
					</div>
				</div>

				<div>
					<div class="accordion">Posts<i class="icon"></i></div>
					<div class="accordion-panel">
					<form>
						<?php get_content_for_menus('post'); ?>
						<button type="submit" class="tiny float-right">Add to menu</button>
					</form>
					</div>
				</div>
				
				<div>
					<div class="accordion">Links<i class="icon"></i></div>
					<div class="accordion-panel">
					<form>
						<?php //get_links_for_menus('link'); ?>
						<button type="submit" class="tiny float-right">Add to menu</button>
					</form>
					</div>
				</div>
				
				<div>
					<div class="accordion">Class<i class="icon"></i></div>
					<div class="accordion-panel">
					<form>
						<?php get_terms_for_menus('class'); ?>
						<button type="submit" class="tiny float-right">Add to menu</button>
					</form>
					</div>
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
</div>