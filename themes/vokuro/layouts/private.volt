<div class="app">
    <aside class="rail">
        {% set brandHtml = tag.img('/img/phalcon.svg', ['alt': '']) ~ '<span class="lbl">Vökuró</span>' %}
        {{ tag.aRaw(url(''), brandHtml, ['class': 'brand']) }}
        <button class="rail-toggle" data-nav-toggle type="button" aria-label="Menu">&#9776;</button>
        <div class="rail-section">Manage</div>
        <nav class="rail-nav">
            {% set usersIcon = '<svg class="ico" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="6" r="3"></circle><path d="M3.5 15c0-3 2.5-5 5.5-5s5.5 2 5.5 5"></path></svg><span class="lbl">Users</span>' %}
            {{ tag.aRaw(url('users'), usersIcon, ['class': ('users' == dispatcher.getControllerName() ? 'is-active' : '')]) }}
            {% set profilesIcon = '<svg class="ico" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="4" width="13" height="10" rx="2"></rect><circle cx="6.3" cy="9" r="1.6"></circle><path d="M10 7.8h3.4M10 10.4h2.8"></path></svg><span class="lbl">Profiles</span>' %}
            {{ tag.aRaw(url('profiles'), profilesIcon, ['class': ('profiles' == dispatcher.getControllerName() ? 'is-active' : '')]) }}
            {% set permissionsIcon = '<svg class="ico" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 2.4l5.2 2v3.8c0 3.3-2.3 5.6-5.2 6.6-2.9-1-5.2-3.3-5.2-6.6V4.4z"></path><path d="M6.8 8.8l1.5 1.5 3-3.2"></path></svg><span class="lbl">Permissions</span>' %}
            {{ tag.aRaw(url('permissions'), permissionsIcon, ['class': ('permissions' == dispatcher.getControllerName() ? 'is-active' : '')]) }}
        </nav>
        <div class="rail-user">
            <span class="avatar">{{ tag.img('/img/phalcon.svg', ['alt': '']) }}</span>
            <div class="who">
                {{ auth.getName() }}<br>
                {{ tag.a(url('users/changePassword'), 'Change password') }} &middot; {{ tag.a(url('session/logout'), 'Logout') }}
            </div>
        </div>
    </aside>

    <section class="content">
        <div class="content-head">
            <div class="crumb">
                <button class="rail-collapse" data-rail-collapse type="button" aria-label="Toggle sidebar">&#9776;</button>
                Manage / <b>{{ dispatcher.getControllerName()|capitalize }}</b>
            </div>
        </div>
        <div class="content-body">
            {{ content() }}
        </div>
    </section>
</div>
