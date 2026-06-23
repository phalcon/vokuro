<div class="page-head">
    <h1>Found users</h1>
</div>

<div class="actions">
    {{ tag.aRaw(url('users/index'), '&larr; Go Back', ['class': 'btn-ghost btn']) }}
    {{ tag.a(url('users/create'), 'Create users', ['class': 'btn']) }}
</div>

<div class="data-table table-scroll">
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Profile</th>
            <th>Banned?</th>
            <th>Suspended?</th>
            <th>Confirmed?</th>
            <th></th>
            <th></th>
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
            <tr>
                <td colspan="9">No users are recorded</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
</div>

<div class="actions">
    {{ tag.a(url('users/search'), 'First', ['class': 'btn-sm btn-ghost btn']) }}
    {{ tag.a(url('users/search?page=' ~ page.previous), 'Previous', ['class': 'btn-sm btn-ghost btn']) }}
    {{ tag.a(url('users/search?page=' ~ page.next), 'Next', ['class': 'btn-sm btn-ghost btn']) }}
    {{ tag.a(url('users/search?page=' ~ page.last), 'Last', ['class': 'btn-sm btn-ghost btn']) }}
</div>
