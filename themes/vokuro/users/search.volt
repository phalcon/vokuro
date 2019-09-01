<h1 class="mt-3">Found users</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to("users/index", "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to("users/create", "Create users", "class": "btn btn-primary") }}
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Profile</th>
        <th>Banned?</th>
        <th>Suspended?</th>
        <th>Confirmed?</th>
    </tr>
    </thead>
    <tbody>
    {% for user in page.items %}
        <tr>
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.profile.name }}</td>
            <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
            <td class="td-width-12">{{ link_to("users/edit/" ~ user.id, '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}</td>
            <td class="td-width-12">{{ link_to("users/delete/" ~ user.id, '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}</td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10">
                No users are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to("users/search", '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to("users/search?page=" ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to("users/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to("users/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
            </div>

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-secondary" disabled>{{ page.current }}</button>
                <button type="button" class="btn btn-secondary" disabled>/</button>
                <button type="button" class="btn btn-secondary" disabled>{{ page.last }}</button>
            </div>
        </td>
    </tr>
    </tfoot>
</table>
