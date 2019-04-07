{{ content() }}
<div class="card">
  <div class="card-body">
    {{ form() }}
    <div class="form-group">
      <label>New Password</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-key"></i></span>
        </div>
        {{ form.render("password") }}
      </div>
    </div>
    <div class="form-group">
      <label>Confirm Password</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-key"></i></span>
        </div>
        {{ form.render("confirmPassword") }}
      </div>
    </div>
    <div class="btn-group">
      {{ submit_button("Save", "class": "btn btn-success") }}
      {{ link_to("/dashboard", 'Cancel', "class": "btn btn-warning") }}
    </div>
    {{ end_form() }}

  </div>
</div>
