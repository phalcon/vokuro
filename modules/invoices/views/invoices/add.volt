<!-- /modules/invoices/views/invoices/add -->

{{ content() }}

{{ flash.output() }}

{{ form("invoices/create") }}
<h1>Add an Invoize</h1>

<ul class="pager">
  <li class="previous pull-left">
    {{ link_to("invoices", "&larr; Go Back") }}
  </li>
  <li class="pull-right">
    {{ submit_button("Save", "class": "btn btn-success") }}
  </li>
</ul>

{# note: this is a comment
  {% set price = 100; %}
    {% set fruits = ['Apple', 'Banana', 'Orange'] %}
#}

<fieldset>
  {% for element in form %}
    {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
      {{ element }}
    {% else %}
      <div class="form-group">
        {{ element.label() }}
        {{ element.render(['class': 'form-control']) }}
      </div>
    {% endif %}
  {% endfor %}

</fieldset>

{{ end_form }}
