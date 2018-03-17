{{ content() }}

<div align="right">
    {{ link_to("robots/create", "<i class='icon-plus-sign'></i> Create Robots", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("robots/search") }}" autocomplete="off">

	<div class="center scaffold">

		<h2>Search robots</h2>

		<div class="clearfix">
			<label for="id">Id</label>
            {{ form.render("id") }}
		</div>

		<div class="clearfix">
			<label for="name">Name</label>
            {{ form.render("name") }}
		</div>

		<div class="clearfix">
			<label for="email">Type</label>
            {{ form.render("type") }}
		</div>

		<div class="clearfix">
			<label for="parts">Parts</label>
            {{ form.render("parts_id") }}
		</div>

		<div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
		</div>

	</div>

</form>