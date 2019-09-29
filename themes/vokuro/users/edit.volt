<h1 class="mt-3">Edit users</h1>

<div class="btn-group mb-5" role="group">
    {{ link_to("users/index", "&larr; Go Back", "class": "btn btn-warning") }}
</div>

{{ flash.output() }}

<form method="post">
    <ul class="nav nav-tabs" id="user-edit-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="logins-tab" data-toggle="tab" href="#logins" role="tab" aria-controls="logins" aria-selected="false">Successful Logins</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="password-changes-tab" data-toggle="tab" href="#password-changes" role="tab" aria-controls="password-changes" aria-selected="false">Password Changes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="password-resets-tab" data-toggle="tab" href="#password-resets" role="tab" aria-controls="password-resets" aria-selected="false">Reset Passwords</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
            <div class="form-group row mt-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    {{ form.render('name', ['class': 'form-control', 'placeholder': 'Name']) }}
                </div>
            </div>

            <div class="form-group row mt-3">
                <label for="profilesId" class="col-sm-2 col-form-label">Profile</label>
                <div class="col-sm-10">
                    {{ form.render('profilesId', ['class': 'form-control']) }}
                </div>
            </div>

            <div class="form-group row mt-3">
                <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
                <div class="col-sm-10">
                    {{ form.render('email', ['class': 'form-control']) }}
                </div>
            </div>

            <div class="form-group row mt-3">
                <label for="suspended" class="col-sm-2 col-form-label">Suspended?</label>
                <div class="col-sm-10">
                    {{ form.render('suspended', ['class': 'form-control']) }}
                </div>
            </div>

            <div class="form-group row mt-3">
                <label for="banned" class="col-sm-2 col-form-label">Banned?</label>
                <div class="col-sm-10">
                    {{ form.render('banned', ['class': 'form-control']) }}
                </div>
            </div>

            <div class="form-group row mt-3">
                <label for="active" class="col-sm-2 col-form-label">Confirmed?</label>
                <div class="col-sm-10">
                    {{ form.render('active', ['class': 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="logins" role="tabpanel" aria-labelledby="logins-tab">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                </tr>
                </thead>
                <tbody>
                {% for login in user.successLogins %}
                    <tr>
                        <td>{{ login.id }}</td>
                        <td>{{ login.ipAddress }}</td>
                        <td>{{ login.userAgent }}</td>
                    </tr>
                {% else %}
                    <tr>
                        <td colspan="3" class="text-center">User does not have successful logins</td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="password-changes" role="tabpanel" aria-labelledby="password-changes-tab">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                {% for change in user.passwordChanges %}
                    <tr>
                        <td>{{ change.id }}</td>
                        <td>{{ change.ipAddress }}</td>
                        <td>{{ change.userAgent }}</td>
                        <td>{{ date("Y-m-d H:i:s", change.createdAt) }}</td>
                    </tr>
                {% else %}
                    <tr>
                        <td colspan="4" class="text-center">User has not changed his/her password</td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="password-resets" role="tabpanel" aria-labelledby="password-resets-tab">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Reset?</th>
                </tr>
                </thead>
                <tbody>
                {% for reset in user.resetPasswords %}
                    <tr>
                        <th>{{ reset.id }}</th>
                        <th>{{ date("Y-m-d H:i:s", reset.createdAt) }}
                        <th>{{ reset.reset == 'Y' ? 'Yes' : 'No' }}
                    </tr>
                {% else %}
                    <tr>
                        <td colspan="3" class="text-center">User has not requested reset his/her password</td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
    </div>

    {{ form.render("id") }}
    {{ submit_button("Save", "class": "btn btn-big btn-success") }}
</form>
