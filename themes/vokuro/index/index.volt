{{ flash.output() }}

<header class="jumbotron" id="overview">
    <h1 class="display-4">Welcome!</h1>
    <p class="lead">This is a website secured by Phalcon Framework</p>
    <hr class="my-4">
    {{ tag.a(
        'session/signup',
        "<i class='icon-ok icon-white'></i> Create an Account",
        ['class': 'btn btn-primary btn-large'],
        true
    ) }}
</header>

<div class="row">
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h3>Awesome Section</h3>
                <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis
                    parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id
                    elit.</p>
                <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo
                    luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-4">
        <h3>Important Stuff</h3>
        <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient
            montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
        <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus,
            nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
    </div>

    <div class="col-md-12 col-lg-4">
        <h3>Example addresses</h3>
        <address>
            <strong>Vökuró, Inc.</strong><br>
            456 Infinite Loop, Suite 101<br>
            <abbr title="Phone">P:</abbr>&nbsp;
            {{ tag.a(
                'tel:+11234567890',
                '(123) 456-7890',
                ['title' : 'Call us']
            ) }}
        </address>
        <address>
            <strong>Contacts</strong><br>
            {{ tag.a(
                'mailto:team@phalcon.io?subject=Vökuró feedback',
                'team@phalcon.io',
                ['title' : 'Send feedback']
            ) }}
        </address>
    </div>
</div>
