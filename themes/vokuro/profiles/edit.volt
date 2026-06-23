<div class="page-head">
    <h1>Edit profile</h1>
</div>

<div class="actions">
    {{ tag.aRaw(url('profiles/index'), '&larr; Go Back', ['class': 'btn-ghost btn']) }}
</div>

{{ flash.output() }}

<form method="post">
    <div class="card">
        <h3>Basic</h3>
        <div class="field">
            <label>Name</label>
            {{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}
        </div>
        <div class="field">
            <label>Active?</label>
            {{ form.render('active', ['class': 'select']) }}
        </div>
        {{ form.render("id") }}
        {{ tag.inputSubmit('save', 'Save', ['class': 'btn']) }}
    </div>
</form>

<div class="card">
    <h3>Users</h3>
    <div class="data-table table-scroll">
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Banned?</th>
                <th>Suspended?</th>
                <th>Active?</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {% for user in profile.users %}
                <tr>
                    <td class="id">{{ user.id }}</td>
                    <td class="name">{{ user.name }}</td>
                    <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
                    <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
                    <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
                    <td>{{ tag.a(url('users/edit/' ~ user.id), 'Edit', ['class': 'btn-sm btn-ghost btn']) }}</td>
                    <td>{{ tag.a(url('users/delete/' ~ user.id), 'Delete', ['class': 'btn-sm btn-danger btn']) }}</td>
                </tr>
            {% else %}
                <tr><td colspan="7">There are no users assigned to this profile</td></tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
