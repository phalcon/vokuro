{%- set menus = [
    'Home': 'index',
    'About': 'about'
] -%}

<div class="topbar">
    <div class="inner">
        {{ link_to(null, 'class': 'brand', '<img src="/img/phalcon.svg" alt=""> Vökuró') }}
        <button class="nav-toggle" data-nav-toggle type="button" aria-label="Menu">&#9776;</button>
        <nav>
            {%- for key, value in menus %}
                {{ link_to(value, 'class': value == dispatcher.getControllerName() ? 'is-active' : '', key) }}
            {%- endfor -%}

            {%- if logged_in is defined and not(logged_in is empty) -%}
                {{ link_to('users', 'Users') }}
                {{ link_to('profiles', 'Profiles') }}
                {{ link_to('permissions', 'Permissions') }}
                {{ link_to('session/logout', 'class': 'btn btn-sm', 'Logout') }}
            {% else %}
                {{ link_to('session/login', 'Login') }}
                {{ link_to('session/signup', 'class': 'btn btn-sm', 'Sign up') }}
            {% endif %}
        </nav>
    </div>
</div>

<main class="container">
    {{ content() }}
</main>

<footer class="footer">
    Made with love by the Phalcon Team &middot;
    {{ link_to('privacy', 'Privacy Policy') }} &middot;
    {{ link_to('terms', 'Terms') }} &middot;
    &copy; {{ date('Y') }} Phalcon Team.
</footer>
