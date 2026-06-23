<h1>Sign Up</h1>
<p>Create your account to get started.</p>

{{ flash.output() }}

<form method="post">
    <div class="field">
        {{ form.label('name') }}
        {{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}
        {% if form.messages('name') %}<div class="field-error">{{ form.messages('name') }}</div>{% endif %}
    </div>

    <div class="field">
        {{ form.label('email') }}
        {{ form.render('email', ['class': 'input', 'placeholder': 'Email']) }}
        {% if form.messages('email') %}<div class="field-error">{{ form.messages('email') }}</div>{% endif %}
    </div>

    <div class="field">
        {{ form.label('password') }}
        {{ form.render('password', ['class': 'input', 'placeholder': 'Password']) }}
        {% if form.messages('password') %}<div class="field-error">{{ form.messages('password') }}</div>{% endif %}
    </div>

    <div class="field">
        {{ form.label('confirmPassword') }}
        {{ form.render('confirmPassword', ['class': 'input', 'placeholder': 'Confirm Password']) }}
        {% if form.messages('confirmPassword') %}<div class="field-error">{{ form.messages('confirmPassword') }}</div>{% endif %}
    </div>

    <div class="check">
        {{ form.render('terms') }}
        {{ form.label('terms') }}
    </div>
    {% if form.messages('terms') %}<div class="field-error">{{ form.messages('terms') }}</div>{% endif %}

    {{ form.render('csrf', ['value': security.getToken()]) }}
    {% if form.messages('csrf') %}<div class="field-error">{{ form.messages('csrf') }}</div>{% endif %}

    {{ form.render('Sign Up', ['class': 'btn']) }}
</form>

<hr>
{{ link_to('session/login', "&larr; Back to Login") }}
