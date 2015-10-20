<!-- relations browse -->

{{ content() }}

{{ flash.output() }}

<h2>Browsing Relations (Clients, Prospects)</h2>

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("relations", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("relations/create", "Create relations") }}
    </li>
</ul>

{% for relation in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Name</th>
            <th>Telephone</th>
            <th>Address</th>
            <th>City</th>
        </tr>
        </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ relation.name }}</td>
        <td>{{ relation.work_phone }}</td>
        <td>{{ relation.address1 }}</td>
        <td>{{ relation.city }}</td>
        <td width="7%">{{ link_to("relations/edit/" ~ relation.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
        <td width="7%">{{ link_to("relations/delete/" ~ relation.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("relations/browse", '<i class="icon-fast-backward"></i> First', "class": "btn btn-default") }}
                    {{ link_to("relations/browse?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-default") }}
                    {{ link_to("relations/browse?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-default") }}
                    {{ link_to("relations/browse?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        <tbody>
        </table>
    {% endif %}
{% else %}
    No relations are recorded
{% endfor %}
