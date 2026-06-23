<div class="page-head">
    <h1>Profiles</h1>
    <p>Group permissions into reusable profiles.</p>
</div>

<div class="actions">
    {{ tag.a(url('profiles/create'), 'Create Profiles', ['class': 'btn']) }}
</div>

{{ flash.output() }}

<div class="card">
    <h3>Search profiles</h3>
    <form method="post" action="{{ url('profiles/search') }}">
        <div class="toolbar">
            {{ form.render('id', ['class': 'input', 'placeholder': 'Id']) }}
            {{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}
            {{ tag.button('Search', ['type': 'submit', 'class': 'btn']) }}
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
    {{ tag.a(url('profiles?page=' ~ page.previous), 'Previous', ['class': 'btn-sm btn-ghost btn']) }}
    <span class="btn-sm btn-ghost btn">{{ page.current }} / {{ page.last }}</span>
    {{ tag.a(url('profiles?page=' ~ page.next), 'Next', ['class': 'btn-sm btn-ghost btn']) }}
</div>
