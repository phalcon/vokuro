<div class="page-head">
    <h1>Change Password</h1>
</div>

{{ flash.output() }}

<div class="card">
    <form method="post" action="{{ url('users/changePassword') }}">
        <div class="field">
            {{ form.label('password') }}
            {{ form.render('password', ['class': 'input', 'placeholder': 'Password']) }}
        </div>

        <div class="field">
            {{ form.label('confirmPassword') }}
            {{ form.render('confirmPassword', ['class': 'input', 'placeholder': 'Confirm Password']) }}
        </div>

        {{ submit_button("Change Password", "class": "btn") }}
    </form>
</div>
