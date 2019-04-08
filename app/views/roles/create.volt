<h1>Roles</h1>
<hr>
<div class="row mb-3">
  <div class="col-12">
    {{ content() }}
    <div class="card">
      <div class="card-header">
        <h4>Add Role</h4>
      </div>
      <div class="card-body">
        {{ form() }}
        <div class="form-group">
          <label for="name">name</label>
          {{ form.render("name", ["class": "form-control"]) }}
        </div>
        <div class="form-group">
          <label for="active">active?</label>
          {{ form.render("active", ["class": "form-control"]) }}
        </div>
        <div class="btn-group">
          {{ submit_button("Save", "class": "btn btn-primary", 'value':'Save') }}
          {{ link_to("/roles", 'Cancel', "class": "btn btn-warning") }}
        </div>
        {{ form.render('csrf', ['value': security.getToken()]) }}
        {{ end_form() }}
      </div>
    </div>
  </div>
  <!-- /.col-12 -->
</div>
