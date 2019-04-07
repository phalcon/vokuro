<h1>Users</h1>
<hr>
<div class="row mb-3">
  <div class="col-12">
    {{ content() }}
    <div class="card">
      <div class="card-header">
        <h4>Add User</h4>
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
        <div class="btn-group">
          {{ submit_button("Save", "class": "btn btn-success", 'value':'Add') }}
          {{ link_to("/users", 'Cancel', "class": "btn btn-warning") }}
        </div>
        {{ form.render('csrf', ['value': security.getToken()]) }}
        {{ end_form() }}
      </div>
    </div>
  </div>
  <!-- /.col-12 -->
</div>
