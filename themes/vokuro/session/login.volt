<h1>Log In</h1>
<p>Welcome back. Enter your details.</p>

{{ flash.output() }}

<form method="post">
    <div class="field">
        <label for="email-input">Email address</label>
        {{ form.render('email', ['class': 'input', 'id': 'email-input', 'placeholder': 'you@phalcon.io']) }}
    </div>

    <div class="field">
        <label for="password-input">Password</label>
        {{ form.render('password', ['class': 'input', 'id': 'password-input', 'placeholder': 'Password']) }}
    </div>

    <div class="check">
        {{ form.render('remember', ['class': 'check-input']) }}
        {{ form.label('remember') }}
    </div>

    {{ form.render('csrf', ['value': security.getToken()]) }}

    {{ form.render('Login', ['class': 'btn']) }}
</form>

<hr>
<p>{{ link_to('session/forgotPassword', 'Forgot my password') }}</p>
<p>{{ link_to('session/signup', 'Sign up') }}</p>
