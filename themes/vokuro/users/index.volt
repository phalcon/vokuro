<div class="page-head">
    <h1>Users</h1>
    <p>Manage who can access Vökuró.</p>
</div>

<div class="actions">
    {{ link_to('users/create', 'class': 'btn', 'Create Users') }}
</div>

{{ flash.output() }}

<div class="card">
    <h3>Search users</h3>
    <form method="get" action="{{ url('users/search') }}">
        <div class="toolbar">
            {{ form.render('id', ['class': 'input', 'placeholder': 'Id']) }}
            {{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}
            {{ form.render('email', ['class': 'input', 'placeholder': 'Email']) }}
            {{ form.render('profilesId', ['class': 'select']) }}
            <button type="submit" class="btn">Search</button>
        </div>
    </form>
</div>

<div class="data-table table-scroll">
    <table>
        <thead>
        <tr>
            <th>Id</th><th>Name</th><th>Email</th><th>Profile</th>
            <th>Banned?</th><th>Suspended?</th><th>Confirmed?</th><th></th><th></th>
        </tr>
        </thead>
        <tbody>
        {% for user in page.items %}
            <tr>
                <td class="id">{{ user.id }}</td>
                <td class="name">{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.profile.name }}</td>
                <td>{{ user.banned == 'Y' ? '<span class="pill pill-warn">Yes</span>' : '<span class="pill pill-ok">No</span>' }}</td>
                <td>{{ user.suspended == 'Y' ? '<span class="pill pill-warn">Yes</span>' : '<span class="pill pill-ok">No</span>' }}</td>
                <td>{{ user.active == 'Y' ? '<span class="pill pill-ok">Yes</span>' : '<span class="pill pill-warn">No</span>' }}</td>
                <td>{{ link_to('users/edit/' ~ user.id, 'class': 'btn-sm btn-ghost btn', 'Edit') }}</td>
                <td>{{ link_to('users/delete/' ~ user.id, 'class': 'btn-sm btn-danger btn', 'Delete') }}</td>
            </tr>
        {% else %}
            <tr><td colspan="9">No users are recorded</td></tr>
        {% endfor %}
        </tbody>
    </table>
</div>

<div class="actions">
    {{ link_to('users?page=' ~ page.previous, 'class': 'btn-sm btn-ghost btn', 'Previous') }}
    <span class="btn-sm btn-ghost btn">{{ page.current }} / {{ page.last }}</span>
    {{ link_to('users?page=' ~ page.next, 'class': 'btn-sm btn-ghost btn', 'Next') }}
</div>
