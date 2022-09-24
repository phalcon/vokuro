{%- set menus = [
    'Home': null,
    'Users': 'users',
    'Profiles': 'profiles',
    'Permissions': 'permissions'
] -%}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    {{ tag.a('/', 'Vökuró', ['class': 'navbar-brand']) }}

    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            {%- for key, value in menus %}
                {% if value == dispatcher.getControllerName() %}
                    <li class="nav-item active">
                        {{ tag.a(value, key, ['class': 'nav-link']) }}
                    </li>
                {% else %}
                    <li class="nav-item">{{ tag.a(value, key, ['class': 'nav-link']) }}</li>
                {% endif %}
            {%- endfor -%}
        </ul>

        <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    {{ auth.getName() }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {{ tag.a('users/changePassword', 'Change Password', ['class': 'dropdown-item']) }}
                </div>
            </li>
            <li class="nav-item">{{ tag.a('session/logout', 'Logout', ['class': 'nav-link']) }}</li>
        </ul>
    </div>
</nav>

<div class="container">
    {{ content() }}
</div>
