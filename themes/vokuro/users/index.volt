<div class="page-head">
    <h1>Users</h1>
    <p>Manage who can access Vökuró.</p>
</div>

<div class="actions">
    {{ tag.a(url('users/create'), 'Create Users', ['class': 'btn']) }}
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
            {{ tag.button('Search', ['type': 'submit', 'class': 'btn']) }}
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
                <td>{{ tag.a(url('users/edit/' ~ user.id), 'Edit', ['class': 'btn-sm btn-ghost btn']) }}</td>
                <td>{{ tag.a(url('users/delete/' ~ user.id), 'Delete', ['class': 'btn-sm btn-danger btn']) }}</td>
            </tr>
        {% else %}
            <tr><td colspan="9">No users are recorded</td></tr>
        {% endfor %}
        </tbody>
    </table>
</div>

<div class="actions">
    {{ tag.a(url('users?page=' ~ page.previous), 'Previous', ['class': 'btn-sm btn-ghost btn']) }}
    <span class="btn-sm btn-ghost btn">{{ page.current }} / {{ page.last }}</span>
    {{ tag.a(url('users?page=' ~ page.next), 'Next', ['class': 'btn-sm btn-ghost btn']) }}
</div>
