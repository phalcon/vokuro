<h1 class="mt-3">Found profiles</h1>

{{ flash.output() }}

<div class="btn-group mb-5" role="group">
    {{ link_to("profiles/index", "&larr; Go Back", "class": "btn btn-warning") }}
    {{ link_to("profiles/create", "Create profiles", "class": "btn btn-primary") }}
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Active?</th>
    </tr>
    </thead>
    <tbody>
    {% for profile in page.items %}
        <tr>
            <td>{{ profile['id'] }}</td>
            <td>{{ profile['name'] }}</td>
            <td>{{ profile['active'] == 'Y' ? 'Yes' : 'No' }}</td>
            <td class="td-width-12">
                {{ link_to("profiles/edit/" ~ profile['id'], '<i class="icon-pencil"></i> Edit', "class": "btn btn-sm btn-outline-warning") }}
            </td>
            <td class="td-width-12">
                {{ link_to("profiles/delete/" ~ profile['id'], '<i class="icon-remove"></i> Delete', "class": "btn btn-sm btn-outline-danger") }}
            </td>
        </tr>
    {% else %}
        <tr>
            <td colspan="10" class="text-center">
                No profiles are recorded
            </td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" class="text-right">
            <div class="btn-group" role="group">
                {{ link_to("profiles/search", '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                {{ link_to("profiles/search?page=" ~ page.previous, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary") }}
                {{ link_to("profiles/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                {{ link_to("profiles/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
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
