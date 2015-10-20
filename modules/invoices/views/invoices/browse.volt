{{ content() }}

{{ flash.output() }}

<h2>Browsing Invoices</h2>


<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("invoices", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("invoices/add", "Create invoice") }}
    </li>
</ul>

{% for invoice in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Number</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ invoice.invoice_number }}</td>
        <td>{{ invoice.customer.name }}</td>
        <td>{{ date('d-m-Y', strtotime(invoice.invoice_date)) }}</td>
        <td>{{ invoice.amount }}</td>
        <td>{{ invoice.status.name }}</td>
        <td width="7%">{{ link_to("invoices/edit/" ~ invoice.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
        <td width="7%">{{ link_to("invoices/delete/" ~ invoice.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("invoices/browse", '<i class="icon-fast-backward"></i> First', "class": "btn btn-default") }}
                    {{ link_to("invoices/browse?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-default") }}
                    {{ link_to("invoices/browse?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-default") }}
                    {{ link_to("invoices/browse?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        <tbody>
        </table>
    {% endif %}
{% else %}
    No invoices are recorded
{% endfor %}
