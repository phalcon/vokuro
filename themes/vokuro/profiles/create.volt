<h1 class="mt-3">Create a Profile</h1>

{{ flash.output() }}

<div class="mb-5">
    {{ tag.a("profiles", "&larr; Go Back", ['class': 'btn btn-primary']) }}
</div>

<form method="post">
    <div class="form-group row">
        {{ form.label('name', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('name', ['class': 'form-control', 'placeholder': 'Name']) }}
        </div>
    </div>

    <div class="form-group row">
        <label for="active" class="col-sm-2 col-form-label">Active?</label>
        <div class="col-sm-10">
            {{ form.render('active', ['class': 'form-control', 'placeholder': 'Active?']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            {{ tag.inputSubmit("Save", "Save", ["class": "btn btn-success"]) }}
        </div>
    </div>
</form>
