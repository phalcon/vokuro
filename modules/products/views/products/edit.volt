{{ flash.output() }}

{{ form("products/save", 'role': 'form') }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("products", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<h2>Edit products</h2>

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

</form>
