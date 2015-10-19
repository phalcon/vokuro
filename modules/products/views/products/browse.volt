{{ content() }}

{{ flash.output() }}

<h2>Browsing Products</h2>

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("products", "&larr; Go Back") }}
    </li>
    <li class="next">
        {{ link_to("products/add", "Create products") }}
    </li>
</ul>

{% for product in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Product Type</th>
            <th>Name</th>
            <th>Price</th>
            <th>Active</th>
        </tr>
        </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ product.productTypes.name }}</td>
        <td>{{ product.name }}</td>
        <td>${{ "%.2f"|format(product.price) }}</td>
        <td>{{ product.getActiveDetail() }}</td>
        <td width="7%">{{ link_to("products/edit/" ~ product.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
        <td width="7%">{{ link_to("products/delete/" ~ product.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>

    </tr>
    </tbody>
    {% if loop.last %}

        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("products/browse", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("products/browse?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("products/browse?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("products/browse?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        </tbody>
        </table>
    {% endif %}
{% else %}
    No products are recorded
{% endfor %}
