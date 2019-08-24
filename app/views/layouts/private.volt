{%- set menus = [
    'Home': null,
    'Users': 'users',
    'Profiles': 'profiles',
    'Permissions': 'permissions'
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth.getName() }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {{ link_to('users/changePassword', 'class': 'dropdown-item', 'Change Password') }}
                </div>
            </li>
            <li class="nav-item">{{ link_to('session/logout', 'class': 'nav-link', 'Logout') }}</li>
        </ul>
    </div>
</nav>

<div class="container">
    {{ content() }}
</div>
