{{ content() }}

<header class="jumbotron">
	<h1>Welcome!</h1>
	<p class="lead">This is a website secured by Phalcon Framework</p>
	<div align="right">
		{{ link_to('session/signup', '<i class="fas fa-check"></i> Create an Account', 'class': 'btn btn-primary') }}
	</div>
</header>

<div class="row">
	<div class="col-sm">
		<div class="card bg-light">
			<div class="card-body">
				<h3>Awesome Section</h3>
				<p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
				<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
			</div>
		</div>
	</div>

	<div class="col-sm">
		<h3>Important Stuff</h3>
		<p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
		<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
	</div>

	<div class="col-sm">
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
