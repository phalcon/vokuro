<div class="page-head">
    <h1>Manage Permissions</h1>
</div>

{{ flash.output() }}

<div class="card">
    <form method="post">
        <div class="field">
            <label for="profileId">Profile</label>
            {{ profilesSelect }}
        </div>

        {{ tag.inputSubmit('search', 'Search', ['class': 'btn']) }}

        {% if request.isPost() and profile %}
        <hr>
        {% for resource, actions in acl.getResources() %}
            <h3>{{ resource }}</h3>
            <div class="data-table table-scroll">
                <table>
                    <thead><tr><th></th><th>Description</th></tr></thead>
                    <tbody>
                    {% for action in actions %}
                        <tr>
                            <td>
                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ resource ~ '.' ~ action }}"
                                    {% if permissions[resource ~ '.' ~ action] is defined %} checked="checked"{% endif %}>
                            </td>
                            <td>{{ acl.getActionDescription(action) ~ ' ' ~ resource }}</td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        {% endfor %}

        {{ tag.inputSubmit('submit', 'Submit', ['class': 'btn']) }}
        {% endif %}
    </form>
</div>
