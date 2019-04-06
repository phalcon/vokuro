{{ content() }}

<form method="post" autocomplete="off" action="{{ url("users/changePassword") }}">

    <div class="center scaffold">

        <h2>Change Password</h2>

        <div class="clearfix">
            <label for="password">Password</label>
            {{ form.render("password") }}
        </div>

        <div class="clearfix">
            <label for="confirmPassword">Confirm Password</label>
            {{ form.render("confirmPassword") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Change Password", "class": "btn btn-primary") }}
        </div>

    </div>

</form>