<h1 class="mt-3">Forgot Password?</h1>

{{ flash.output() }}

<form method="post">
    <div class="form-group">
        <label for="forgot-email-input">Email address</label>
        {{ form.render('email', ['class': 'form-control', 'id': 'forgot-email-input', 'placeholder': 'Enter email']) }}
    </div>

    {{ form.render('Send') }}
</form>

<hr />

{{ link_to('session/login', "&larr; Back to Login") }}
