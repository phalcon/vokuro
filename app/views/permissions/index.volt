<h1 class="mt-3">Manage Permissions</h1>

<form method="post" class="mt-3 mb-5">
    <div class="form-group">
        <label for="id">Profile</label>
        {{ profilesSelect }}
    </div>

    {{ submit_button('Search', 'class': 'btn btn-primary', 'name' : 'search') }}

    {% if request.isPost() and profile %}
    <hr />
    <div class="mt-3 mb-5">
        {% for resource, actions in acl.getResources() %}
            <h3>{{ resource }}</h3>

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="td-width-5"></th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                {% for action in actions %}
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="permissions[]" value="{{ resource ~ '.' ~ action }}" {% if permissions[resource ~ '.' ~ action] is defined %} checked="checked" {% endif %}>
                        </td>
                        <td>{{ acl.getActionDescription(action) ~ ' ' ~ resource }}</td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
        {% endfor %}

        {{ submit_button('Submit', 'class': 'btn btn-primary', 'name':'submit') }}
    </div>
    {% endif %}
</form>
