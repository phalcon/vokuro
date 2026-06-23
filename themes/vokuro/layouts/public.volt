{%- set menus = [
    'Home': 'index',
    'About': 'about'
] -%}

<div class="topbar">
    <div class="inner">
        {{ tag.aRaw(url(''), tag.img('/img/phalcon.svg', ['alt': '']) ~ ' Vökuró', ['class': 'brand']) }}
        <button class="nav-toggle" data-nav-toggle type="button" aria-label="Menu">&#9776;</button>
        <nav>
            {%- for key, value in menus %}
                {{ tag.a(url(value), key, ['class': (value == dispatcher.getControllerName() ? 'is-active' : '')]) }}
            {%- endfor -%}

            {%- if logged_in is defined and not(logged_in is empty) -%}
                {{ tag.a(url('users'), 'Users') }}
                {{ tag.a(url('profiles'), 'Profiles') }}
                {{ tag.a(url('permissions'), 'Permissions') }}
                {{ tag.a(url('session/logout'), 'Logout', ['class': 'btn btn-sm']) }}
            {% else %}
                {{ tag.a(url('session/login'), 'Login') }}
                {{ tag.a(url('session/signup'), 'Sign up', ['class': 'btn btn-sm']) }}
            {% endif %}
        </nav>
    </div>
</div>

<main class="container">
    {{ content() }}
</main>

<footer class="footer">
    Made with love by the Phalcon Team &middot;
    {{ tag.a(url('privacy'), 'Privacy Policy') }} &middot;
    {{ tag.a(url('terms'), 'Terms') }} &middot;
    &copy; {{ date('Y') }} Phalcon Team.
</footer>
