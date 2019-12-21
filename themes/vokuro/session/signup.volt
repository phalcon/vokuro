{% set isNameValidClass = form.messages('name') ? 'form-control is-invalid' : 'form-control' %}
{% set isEmailValidClass = form.messages('email') ? 'form-control is-invalid' : 'form-control' %}
{% set isPasswordValidClass = form.messages('password') ? 'form-control is-invalid' : 'form-control' %}
{% set isConfigPasswordValidClass = form.messages('confirmPassword') ? 'form-control is-invalid' : 'form-control' %}
{% set isETermsValidClass = form.messages('terms') ? 'form-check-input is-invalid' : 'form-check-input' %}

<h1 class="mt-3">Sign Up</h1>

{{ flash.output() }}

<form method="post">
    <div class="form-group row">
        {{ form.label('name', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('name', ['class': isNameValidClass, 'placeholder': 'Name']) }}
            <div class="invalid-feedback">
                {{ form.messages('name') }}
            </div>
        </div>
    </div>

    <div class="form-group row">
        {{ form.label('email', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('email', ['class': isEmailValidClass, 'placeholder': 'Email']) }}
            <div class="invalid-feedback">
                {{ form.messages('email') }}
            </div>
        </div>
    </div>

    <div class="form-group row">
        {{ form.label('password', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('password', ['class': isPasswordValidClass, 'placeholder': 'Password']) }}
            <div class="invalid-feedback">
                {{ form.messages('password') }}
            </div>
        </div>
    </div>

    <div class="form-group row">
        {{ form.label('confirmPassword', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('confirmPassword', ['class': isConfigPasswordValidClass, 'placeholder': 'Confirm Password']) }}
            <div class="invalid-feedback">
                {{ form.messages('confirmPassword') }}
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2">Terms and conditions</div>
        <div class="col-sm-10">
            <div class="form-check">
                {{ form.render('terms', ['class': isETermsValidClass]) }}
                {{ form.label('terms', ['class': 'form-check-label']) }}
            </div>
            <div class="invalid-feedback">
                {{ form.messages('terms') }}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            {{ form.render('csrf', ['value': security.getToken()]) }}
            {{ form.messages('csrf') }}

            {{ form.render('Sign Up') }}
        </div>
    </div>
</form>

<hr>

{{ link_to('session/login', "&larr; Back to Login") }}
