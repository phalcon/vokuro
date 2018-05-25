{{ form('role': 'form', 'autocomplete' : 'off') }}

<div class="row mb-4">
    <div class="col-6">
        {{ link_to("profiles", '<span class="oi oi-chevron-left" title="chevron-left" aria-hidden="true"></span> Go Back', "class": "btn btn-outline-primary") }}
    </div>
    <div class="col-6 text-right">
        {{ submit_button('Save', "class": "btn btn-big btn-success") }}
    </div>
</div>    

{{ content() }}

<div class="row d-flex justify-content-center">
    <div class="col-md-8  mb-4 mt-4">
        <h2 class="mb-sm-6 pb-sm-2">Edit profile</h2>        

        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" role="tab" href="#A" data-toggle="tab">Basic</a></li>
            <li class="nav-item"><a class="nav-link" href="#B" role="tab" data-toggle="tab">Users</a></li>
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
                            {{ form.label('active') }}    
                            {{ form.render('active' , ['class' : 'form-control ']) }}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" role="tabpanel" id="B">
                    <div class="table-responsive">  
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Banned?</th>
                                    <th>Suspended?</th>
                                    <th>Active?</th>
                                    <th colspan="2">Action</th>
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
                                        <td width="12%">{{ link_to("users/edit/" ~ user.id, '<span class="oi oi-pencil" title="pencil" aria-hidden="true"></span> Edit', "class": "btn btn-light btn-sm") }}</td>
                                        <td width="12%">{{ link_to("users/delete/" ~ user.id, '<span class="oi oi-x" title="X" aria-hidden="true"></span> Delete', "class": "btn btn-light btn-sm") }}</td>
                                    </tr>
                                {% else %}
                                    <tr><td colspan="6" align="center">There are no users assigned to this profile</td></tr>
                                {% endfor %}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</form>
