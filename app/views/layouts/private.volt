<nav id="topNav" class="navbar navbar-expand-sm navbar-dark bg-secondary">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" area-expanded="false" aria-label="Toggle Navigation">
        <span class="oi oi-menu" title="MENU" aria-hidden="true"></span>
    </button>
        
        <div class="collapse navbar-collapse" id="nav-content">  
            <ul class="navbar-nav">

              {%- set menus = [
              'Home': null,
              'Users': 'users',
              'Profiles': 'profiles',
              'Permissions': 'permissions'
            ] -%}

                {%- for key, value in menus %}
                    {% if value == dispatcher.getControllerName() %}
                    <li class="active nav-item">{{ link_to(value, key, 'class':'nav-link') }}</li>
                    {% else %}
                    <li>{{ link_to(value, key, 'class':'nav-link') }}</li>
                    {% endif %}
                {%- endfor -%}

            </ul>
        </div> <!-- navbar-collapse -->
        
        {{ link_to(null, 'class': 'navbar-brand', 'Vökuró')}}
        
        <button class="navbar-toggler justify-content-end" type="button" data-toggle="collapse" data-target="#nav-content-secondary" aria-controls="nav-content-secondary" area-expanded="false" aria-label="Toggle Navigation Secondary">
        <span class="oi oi-person" title="person" aria-hidden="true"></span>

        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="nav-content-secondary">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
              <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="drop-menu">{{ auth.getName() }}</a> 
            <div class="dropdown-menu dropdown-menu-right" aria-lablledby="drop-menu">
              {{ link_to('users/changePassword', 'Change Password' , 'class': 'dropdown-item') }}
            </div>
          </li>
          <li class="nav-item">{{ link_to('session/logout', 'Logout', 'class': 'nav-link')}}</li>
        </ul>                
        </div>

 </nav>

        <main role="main" class="container mt-4">           
            {{ content() }}            
        </main>

 {# our common footer #}
{% include 'partials/footer.volt' %}
