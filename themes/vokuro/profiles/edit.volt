<h1 class="mt-3">Edit profile</h1>

{{ flash.output() }}

<div class="btn-group mb-5" role="group">
    {{ tag.a("profiles/index", "&larr; Go Back", ["class": "btn btn-warning"], true) }}
</div>

{{ tag.form(["method" :"post"]) }}
    <ul class="nav nav-tabs" id="profile-edit-tabs" role="tablist">
        <li class="nav-item">
            {{
                tag.a(
                    "#basic",
                    "Basic",
                    [
                        "id" : "profile-edit-basic-tab",
                        "class" : "nav-link active",
                        "role" : "tab",
                        "data-toggle" : "tab",
                        "aria-controls" : "basic",
                        "aria-selected" : "true"
                    ]
                )
            }}
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-edit-users-tab" data-toggle="tab" href="#users" role="tab"
               aria-controls="users" aria-selected="false">
                Users
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="profile-edit-basic-tab">
            <div class="form-group row mt-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    {{ form.render('name', ['class': 'form-control', 'placeholder': 'Name']) }}
                </div>
            </div>

            <div class="form-group row mt-3">
                <label for="name" class="col-sm-2 col-form-label">Active?</label>
                <div class="col-sm-10">
                    {{ form.render('active', ['class': 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="profile-edit-users-tab">
            <table class="table table-bordered table-striped mt-3">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Banned?</th>
                    <th>Suspended?</th>
                    <th>Active?</th>
                </tr>
                </thead>
                <tbody>
                {% for user in profile.users %}
                    <tr>
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
                        <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
                        <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
                        <td width="12%">
                            {{
                                tag.a(
                                    "users/edit/" ~ user.id,
                                    "<i class='icon-pencil'></i> Edit",
                                    ["class": "btn btn-sm btn-outline-warning"],
                                    true
                                )
                            }}
                        </td>
                        <td width="12%">
                            {{
                                tag.a(
                                    "users/delete/" ~ user.id,
                                    "<i class='icon-remove'></i> Delete",
                                    ["class": "btn btn-sm btn-outline-danger"],
                                    true
                                )
                            }}
                        </td>
                    </tr>
                {% else %}
                    <tr>
                        <td colspan="3" align="center">
                            There are no users assigned to this profile
                        </td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
    </div>

    {{ form.render("id") }}
    {{ tag.inputSubmit("Save", "Save", ["class": "btn btn-success"]) }}
{{ tag.close("form") }}
