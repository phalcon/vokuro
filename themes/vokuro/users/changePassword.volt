<h1 class="mt-3">Change Password</h1>

{{ flash.output() }}

<form method="post" action="{{ url("users/changePassword") }}">
    <div class="form-group row">
        {{ form.label('password', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('password', ['class': 'form-control', 'placeholder': 'Password']) }}
        </div>
    </div>

    <div class="form-group row">
        {{ form.label('confirmPassword', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('confirmPassword', ['class': 'form-control', 'placeholder': 'Confirm Password']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            {{ submit_button("Change Password", "class": "btn btn-primary") }}
        </div>
    </div>
</form>
