{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("robots/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("robots/create", "Create robot", "class": "btn btn-primary") }}
    </li>
</ul>

{% for robot in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Type</th>
            <th>Year</th>
            <th>Parts</th>
        </tr>
    </thead>
    <tbody>
{% endif %}
        <tr>
            <td>{{ robot.id }}</td>
            <td>{{ robot.name }}</td>
            <td>{{ robot.type }}</td>
            <td>{{ robot.year }}</td>
            <td></td>
            <td width="12%">{{ link_to("robots/edit/" ~ robot.id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}</td>
            <td width="12%">{{ link_to("robots/delete/" ~ robot.id, '<i class="icon-remove"></i> Delete', "class": "btn") }}</td>
        </tr>
{% if loop.last %}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("robots/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("robots/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("robots/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("robots/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
{% endif %}
{% else %}
    No robot was found.
{% endfor %}
