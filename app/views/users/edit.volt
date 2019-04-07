<h1>Users</h1>
<hr>
<div class="row mb-3">
  <div class="col-12">
    {{ content() }}
    <div class='row'>
      <div class='col-lg-7 col-md-7 col-sm-7'>
        <div class="card">
          <div class="card-header">
            <h4>User - {{user.name}}</h4>
          </div>
          <div class="card-body">
            {{ form() }}
            <div class="form-group">
              <label for="name">name</label>
              {{ form.render("name", ["class": "form-control"]) }}
            </div>
            <div class="form-group">
              <label for="email">e-mail</label>
              {{ form.render("email", ["class": "form-control"]) }}
            </div>
            <div class="form-group">
              <label for="roleID">role</label>
              {{ form.render("roleID", ["class": "form-control"]) }}
            </div>
            <div class="form-group">
              <label for="active">active?</label>
              {{ form.render("active", ["class": "form-control"]) }}
            </div>
            <div class="btn-group">
              {{ submit_button('Save', 'class': 'btn btn-success', 'value':'Save') }}
              {{ link_to("/users", 'Cancel', "class": "btn btn-warning") }}
            </div>
            {{ form.render('csrf', ['value': security.getToken()]) }}
            {{ end_form() }}
          </div>
        </div>
      </div>

      <div class='col-lg-5 col-md-5 col-sm-5'>
        <div class="card">
          <div class="card-header">
            <h4>Information</h4>
          </div>
          <div class="card-body">
            <p><b>Last login</b>: --</p>
            <p><b>Registration date</b>: August 16, 2018</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.col-12 -->
</div>
