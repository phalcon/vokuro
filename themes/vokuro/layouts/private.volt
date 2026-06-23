<div class="app">
    <aside class="rail">
        {{ link_to(null, 'class': 'brand', '<img src="/img/phalcon.svg" alt=""><span class="lbl">Vökuró</span>') }}
        <button class="rail-toggle" data-nav-toggle type="button" aria-label="Menu">&#9776;</button>
        <div class="rail-section">Manage</div>
        <nav class="rail-nav">
            {{ link_to('users', 'class': 'users' == dispatcher.getControllerName() ? 'is-active' : '', '<svg class="ico" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="6" r="3"></circle><path d="M3.5 15c0-3 2.5-5 5.5-5s5.5 2 5.5 5"></path></svg><span class="lbl">Users</span>') }}
            {{ link_to('profiles', 'class': 'profiles' == dispatcher.getControllerName() ? 'is-active' : '', '<svg class="ico" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="4" width="13" height="10" rx="2"></rect><circle cx="6.3" cy="9" r="1.6"></circle><path d="M10 7.8h3.4M10 10.4h2.8"></path></svg><span class="lbl">Profiles</span>') }}
            {{ link_to('permissions', 'class': 'permissions' == dispatcher.getControllerName() ? 'is-active' : '', '<svg class="ico" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 2.4l5.2 2v3.8c0 3.3-2.3 5.6-5.2 6.6-2.9-1-5.2-3.3-5.2-6.6V4.4z"></path><path d="M6.8 8.8l1.5 1.5 3-3.2"></path></svg><span class="lbl">Permissions</span>') }}
        </nav>
        <div class="rail-user">
            <span class="avatar"><img src="/img/phalcon.svg" alt=""></span>
            <div class="who">
                {{ auth.getName() }}<br>
                {{ link_to('users/changePassword', 'Change password') }} &middot; {{ link_to('session/logout', 'Logout') }}
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
