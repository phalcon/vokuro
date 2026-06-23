<div class="page-head">
    <h1>Profiles</h1>
    <p>Group permissions into reusable profiles.</p>
</div>

<div class="actions">
    {{ link_to('profiles/create', 'class': 'btn', 'Create Profiles') }}
</div>

{{ flash.output() }}

<div class="card">
    <h3>Search profiles</h3>
    <form method="post" action="{{ url('profiles/search') }}">
        <div class="toolbar">
            {{ form.render('id', ['class': 'input', 'placeholder': 'Id']) }}
            {{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}
            <button type="submit" class="btn">Search</button>
        </div>
    </form>
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
    {{ link_to('profiles?page=' ~ page.previous, 'class': 'btn-sm btn-ghost btn', 'Previous') }}
    <span class="btn-sm btn-ghost btn">{{ page.current }} / {{ page.last }}</span>
    {{ link_to('profiles?page=' ~ page.next, 'class': 'btn-sm btn-ghost btn', 'Next') }}
</div>
