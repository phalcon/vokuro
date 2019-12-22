<h1 class="mt-3">Search profiles</h1>

{{ flash.output() }}

<div class="mb-5">
    {{ link_to("profiles/create", "<i class='icon-plus-sign'></i> Create Profiles", "class": "btn btn-primary") }}
</div>

<form method="post" class="form-inline" action="{{ url("profiles/search") }}">
    <div class="form-group">
        <label for="id" class="sr-only">Id</label>
        {{ form.render('id', ['class': 'form-control mr-sm-2', 'placeholder': 'Id']) }}
    </div>

    <div class="form-group">
        <label for="name" class="sr-only">Name</label>
        {{ form.render('name', ['class': 'form-control mr-sm-2', 'placeholder': 'Name']) }}
    </div>

    {{ submit_button("Search", "class": "btn btn-primary") }}
</form>
