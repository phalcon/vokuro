{{ content() }}

<div class="jumbotron" id="overview">
    <div class="container-fluid">
        <h1 class="display-3">Welcome!</h1>
        <p class="lead">This is a website secured by Phalcon Framework</p>
      
        <div align="right">
        {%- if logged_in is empty -%}
            {{ link_to(
                    'session/signup',
                    '<span class="oi oi-check" aria-hidden="true"></span> Create an Account',
                    'class': 'btn btn-primary btn-lg'
                )
            }}
        {% else %}
            {{ link_to(
                    'users',
                    '<span class="oi oi-account-login" aria-hidden="true"></span> Enter User Panel',
                    'class': 'btn btn-primary btn-lg'
                )
            }}
        {% endif %}
        </div>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
            <h3 class="card-header">Awesome Section</h3>
            <div class="card-body">
                <p class="card-text">Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p class="card-text">Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
                <a href="#" class="btn btn-secondary btn-block">Know more</a>   
            </div>
            </div>
        </div>


        <div class="col-md-4 mb-3">
            <h3>Important Stuff</h3>
            <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
        </div>

        <div class="col-md-4 mb-3">
            <h3>Example addresses</h3>
            <address>
                <strong>Vokuri, Inc.</strong><br>
                456 Infinite Loop, Suite 101<br>
                <abbr title="Phone">P:</abbr> (123) 456-7890
            </address>
            <address>
                <strong>Full Name</strong><br>
                <a href="mailto:#">vokuro@phalconphp.com</a>
            </address>
        </div>

    </div>
</div>
        