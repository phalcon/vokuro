
{{ form('role': 'form', 'autocomplete' : 'off') }}

<div class="row mb-4">
    <div class="col-6">
        {{ link_to("users", '<span class="oi oi-chevron-left" title="chevron-left" aria-hidden="true"></span> Go Back', "class": "btn btn-outline-primary") }}
    </div>
    <div class="col-6 text-right">
        {{ submit_button('Save', "class": "btn btn-big btn-success") }}
    </div>
</div>    

{{ content() }}

<div class="row d-flex justify-content-center">
    <div class="col-md-8  mb-4 mt-4">
        <h2 class="mb-sm-6 pb-sm-2">Edit users</h2>        

        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" role="tab" href="#A" data-toggle="tab">Basic</a></li>
            <li class="nav-item"><a class="nav-link" href="#B" role="tab" data-toggle="tab">Successful Logins</a></li>
            <li class="nav-item"><a class="nav-link" href="#C" role="tab" data-toggle="tab">Password Changes</a></li>
            <li class="nav-item"><a class="nav-link" href="#D" role="tab" data-toggle="tab">Reset Passwords</a></li>
        </ul>

        <div class="tabbable mt-4">
            <div class="tab-content">
                <div class="tab-pane active fade show" role="tabpanel" id="A">

                    {{ form.render("id") }}

                    <div class="form-group row">
                        <div class="col-sm-6">
                            {{ form.label('name') }}    
                            {{ form.render('name' , ['class' : 'form-control ']) }}
                        </div>
                        <div class="col-sm-6">
                            {{ form.label('email') }}    
                            {{ form.render('email' , ['class' : 'form-control ']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            {{ form.label('profilesId') }}    
                            {{ form.render('profilesId' , ['class' : 'form-control ']) }}
                        </div>
                        <div class="col-sm-6">
                            {{ form.label('banned') }}    
                            {{ form.render('banned' , ['class' : 'form-control ']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            {{ form.label('suspended') }}    
                            {{ form.render('suspended' , ['class' : 'form-control ']) }}
                        </div>
                        <div class="col-sm-6">
                            {{ form.label('active') }}    
                            {{ form.render('active' , ['class' : 'form-control ']) }}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" role="tabpanel" id="B">
                    <p>
                    <table class="table table-bordered table-striped" class="text-center">
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
                                <tr><td colspan="3" align="center">User does not have successfull logins</td></tr>
                            {% endfor %}
                        </tbody>
                    </table>
                    </p>
                </div>

                <div class="tab-pane fade" role="tabpanel" id="C">
                    <p>
                    <table class="table table-bordered table-striped" align="center">
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
                                <tr><td colspan="4" align="center">User has not changed his/her password</td></tr>
                            {% endfor %}
                        </tbody>
                    </table>
                    </p>
                </div>

                <div class="tab-pane fade" role="tabpanel" id="D">
                    <p>
                    <table class="table table-bordered table-striped" align="center">
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
                                <tr><td colspan="3" align="center">User has not requested reset his/her password</td></tr>
                            {% endfor %}
                        </tbody>
                    </table>
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>                    
</form>