{{ flash.output() }}

<header class="hero">
    <h1>Welcome!</h1>
    <p>
        A sample application secured by the Phalcon Framework - manage users,
        profiles and permissions in one place.
    </p>
    <p>{{ tag.a(url('session/signup'), 'Create an account', ['class': 'btn btn-green']) }}</p>
</header>

<div class="feature-grid">
    <div class="feature">
        <h3>Access control</h3>
        <p>Fine-grained ACL across every controller and action.</p>
    </div>
    <div class="feature">
        <h3>Role-based profiles</h3>
        <p>Group permissions into reusable profiles.</p>
    </div>
    <div class="feature">
        <h3>Full audit trail</h3>
        <p>Track successful and failed logins.</p>
    </div>
    <div class="feature">
        <h3>Secure sessions</h3>
        <p>Encrypted remember-me tokens and CSRF protection.</p>
    </div>
</div>
