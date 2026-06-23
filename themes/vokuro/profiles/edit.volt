<div class="page-head">
    <h1>Edit profile</h1>
</div>

<div class="actions">
    {{ link_to('profiles/index', 'class': 'btn-ghost btn', '&larr; Go Back') }}
</div>

{{ flash.output() }}

<form method="post">
    <div class="card">
        <h3>Basic</h3>
        <div class="field"><label>Name</label>{{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}</div>
        <div class="field"><label>Active?</label>{{ form.render('active', ['class': 'select']) }}</div>
        {{ form.render("id") }}
        {{ submit_button("Save", "class": "btn") }}
    </div>
</form>

<div class="card">
    <h3>Users</h3>
    <div class="data-table table-scroll">
        <table>
            <thead>
            <tr><th>Id</th><th>Name</th><th>Banned?</th><th>Suspended?</th><th>Active?</th><th></th><th></th></tr>
            </thead>
            <tbody>
            {% for user in profile.users %}
                <tr>
                    <td class="id">{{ user.id }}</td>
                    <td class="name">{{ user.name }}</td>
                    <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
                    <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
                    <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
                    <td>{{ link_to('users/edit/' ~ user.id, 'class': 'btn-sm btn-ghost btn', 'Edit') }}</td>
                    <td>{{ link_to('users/delete/' ~ user.id, 'class': 'btn-sm btn-danger btn', 'Delete') }}</td>
                </tr>
            {% else %}
                <tr><td colspan="7">There are no users assigned to this profile</td></tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
