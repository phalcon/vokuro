<h1>Forgot Password?</h1>
<p>Enter your email and we'll send a reset link.</p>

{{ flash.output() }}

<form method="post">
    <div class="field">
        <label for="forgot-email-input">Email address</label>
        {{ form.render('email', ['class': 'input', 'id': 'forgot-email-input', 'placeholder': 'Enter email']) }}
    </div>

    {{ form.render('Send', ['class': 'btn']) }}
</form>

<hr>
{{ link_to('session/login', "&larr; Back to Login") }}
