<div class="page-head">
    <h1>Found profiles</h1>
</div>

<div class="actions">
    {{ tag.aRaw(url('profiles/index'), '&larr; Go Back', ['class': 'btn-ghost btn']) }}
    {{ tag.a(url('profiles/create'), 'Create profiles', ['class': 'btn']) }}
</div>

<div class="data-table table-scroll">
    <table>
        <thead>
        <tr><th>Id</th><th>Name</th><th>Active?</th><th></th><th></th></tr>
        </thead>
        <tbody>
        {% for profile in page.items %}
            <tr>
                <td class="id">{{ profile.id }}</td>
                <td class="name">{{ profile.name }}</td>
                <td>{{ profile.active == 'Y' ? '<span class="pill pill-ok">Yes</span>' : '<span class="pill pill-warn">No</span>' }}</td>
                <td>{{ tag.a(url('profiles/edit/' ~ profile.id), 'Edit', ['class': 'btn-sm btn-ghost btn']) }}</td>
                <td>{{ tag.a(url('profiles/delete/' ~ profile.id), 'Delete', ['class': 'btn-sm btn-danger btn']) }}</td>
            </tr>
        {% else %}
            <tr><td colspan="5">No profiles are recorded</td></tr>
        {% endfor %}
        </tbody>
    </table>
</div>

<div class="actions">
    {{ tag.a(url('profiles/search'), 'First', ['class': 'btn-sm btn-ghost btn']) }}
    {{ tag.a(url('profiles/search?page=' ~ page.previous), 'Previous', ['class': 'btn-sm btn-ghost btn']) }}
    {{ tag.a(url('profiles/search?page=' ~ page.next), 'Next', ['class': 'btn-sm btn-ghost btn']) }}
    {{ tag.a(url('profiles/search?page=' ~ page.last), 'Last', ['class': 'btn-sm btn-ghost btn']) }}
</div>
