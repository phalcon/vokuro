<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
  {{ renderTitle() }}
  {{ stylesheet_link('/css/bootstrap.min.css') }}
  {{ stylesheet_link('/css/fontawesome.min.css') }}
  {{ stylesheet_link('/css/solid.min.css') }}
  {{ stylesheet_link('/css/my_public.css') }}
</head>
<body>

  <div class="container main-container">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
      <a class="navbar-brand" href="/">Vökuró</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          {%- set menus = [
            'Home': 'index',
            'About': 'about'
            ] -%}
            {%- for key, value in menus %}
            {% if value == dispatcher.getControllerName() %}
            <li class="nav-item active">
              {{ link_to(value, key, 'class' : 'nav-link') }}
            </li>
            {% else %}
            <li class="nav-item">
              {{ link_to(value, key, 'class' : 'nav-link') }}
            </li>
            {% endif %}
            {%- endfor -%}
          </ul>
          <ul class="navbar-nav mr-right">
            {%- if logged_in is defined and not(logged_in is empty) -%}
            <li>{{ link_to('dashboard', 'User Panel', 'class' : 'nav-link') }}</li>
            <li>{{ link_to('session/logout', 'Logout', 'class' : 'nav-link') }}</li>
            {% else %}
            <li>{{ link_to('session/login', 'Login', 'class' : 'nav-link') }}</li>
            <li>{{ link_to('session/signup', 'Sign up', 'class' : 'nav-link') }}</li>
            {% endif %}
          </ul>
        </div>
      </nav>

      {{ content() }}


    </div>

    <footer class="container footer">
      <hr>
      <p class="float-right"><a href="#">Back to top</a></p>
      <p>&copy; {{ date("Y") }} Made with love by the Phalcon Team {{ link_to("privacy", "Privacy Policy") }} {{ link_to("terms", "Terms") }}</p>
    </footer>

    {{ javascript_include('/js/jquery-3.3.1.min.js', false) }}
    {{ javascript_include('/js/bootstrap.min.js', false) }}
    {{ javascript_include('/js/bootstrap.bundle.min.js', false) }}
  </body>
