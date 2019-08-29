{%- set menus = [
    'Home': 'index',
    'About': 'about'
] -%}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    {{ link_to(null, 'class': 'navbar-brand', 'Vökuró') }}

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            {%- for key, value in menus %}
                {% if value == dispatcher.getControllerName() %}
                <li class="nav-item active">
                    {{ link_to(value, 'class': 'nav-link', key) }}
                </li>
                {% else %}
                <li class="nav-item">{{ link_to(value, 'class': 'nav-link', key) }}</li>
                {% endif %}
            {%- endfor -%}
        </ul>

        <ul class="navbar-nav my-2 my-lg-0">
        {%- if logged_in is defined and not(logged_in is empty) -%}
            <li class="nav-item">{{ link_to('users', 'class': 'nav-link', 'Users Panel') }}</li>
            <li class="nav-item">{{ link_to('session/logout', 'class': 'nav-link', 'Logout') }}</li>
        {% else %}
            <li class="nav-item">{{ link_to('session/login', 'class': 'nav-link', 'Login') }}</li>
        {% endif %}
        </ul>
    </div>
</nav>

<main role="main" class="flex-shrink-0">
    <div class="container">
        {{ content() }}
    </div>
</main>

<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">
            Made with love by the Phalcon Team

            {{ link_to("privacy", "Privacy Policy") }}
            {{ link_to("terms", "Terms") }}

            © {{ date("Y") }} Phalcon Team.
        </span>
    </div>
</footer>
