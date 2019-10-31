<h1 class="mt-3">Create a User</h1>

<div class="mb-5">
    {{ link_to("users", 'class': 'btn btn-primary', "&larr; Go Back") }}
</div>

{{ flash.output() }}

<form method="post">
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            {{ form.render('name', ['class': 'form-control', 'placeholder': 'Name']) }}
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
        <div class="col-sm-10">
            {{ form.render('email', ['class': 'form-control', 'placeholder': 'E-Mail']) }}
        </div>
    </div>

    <div class="form-group row">
        <label for="profilesId" class="col-sm-2 col-form-label">Profile</label>
        <div class="col-sm-10">
            {{ form.render('profilesId', ['class': 'form-control']) }}
        </div>
    </div>

    {{ submit_button("Save", "class": "btn btn-success") }}
</form>
