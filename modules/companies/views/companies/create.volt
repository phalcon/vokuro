{{ content() }}

{{ flash.output() }}

{{ form("companies/create") }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("products", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>


<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Details</h3>
                        <fieldset>
                            {% for element in form %}
                                {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
                                    {{ element }}
                                {% else %}
                                    <div class="form-group">
                                        {{ element.label() }}
                                        <div class="col-lg-8 col-sm-8">
                                            {{ element.render(['class': 'form-control']) }}
                                        </div>
                                    </div>
                                {% endif %}
                            {% endfor %}
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
