<div class="auth">
    <div class="auth-brand">
        {{ tag.aRaw(url(''), tag.img('/img/phalcon.svg', ['alt': '']) ~ ' Vökuró', ['class': 'brand']) }}
        <div class="tagline">
            <h2>Secure access,<br>simply managed.</h2>
            <p>Users, profiles and permissions in one place - built on Phalcon.</p>
        </div>
    </div>
    <div class="auth-form">
        <div class="box">
            {{ content() }}
        </div>
    </div>
</div>
