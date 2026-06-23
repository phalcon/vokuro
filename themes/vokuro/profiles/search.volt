<div class="page-head">
    <h1>Found profiles</h1>
</div>

<div class="actions">
    {{ link_to('profiles/index', 'class': 'btn-ghost btn', '&larr; Go Back') }}
    {{ link_to('profiles/create', 'class': 'btn', 'Create profiles') }}
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
                <td>{{ link_to('profiles/edit/' ~ profile.id, 'class': 'btn-sm btn-ghost btn', 'Edit') }}</td>
                <td>{{ link_to('profiles/delete/' ~ profile.id, 'class': 'btn-sm btn-danger btn', 'Delete') }}</td>
            </tr>
        {% else %}
            <tr><td colspan="5">No profiles are recorded</td></tr>
        {% endfor %}
        </tbody>
    </table>
</div>

<div class="actions">
    {{ link_to('profiles/search', 'class': 'btn-sm btn-ghost btn', 'First') }}
    {{ link_to('profiles/search?page=' ~ page.previous, 'class': 'btn-sm btn-ghost btn', 'Previous') }}
    {{ link_to('profiles/search?page=' ~ page.next, 'class': 'btn-sm btn-ghost btn', 'Next') }}
    {{ link_to('profiles/search?page=' ~ page.last, 'class': 'btn-sm btn-ghost btn', 'Last') }}
</div>
