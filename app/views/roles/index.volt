<h1>Roles</h1>
<hr>
<div class="row mb-3">
  <div class="col-12">
    {{ content() }}
    <div class="card">
      <div class="card-header">
        {{ link_to("roles/create", "Add Role", "class": "btn btn-primary btn-sm") }}
      </div>

      <div class="card-body">
        <div class="row">
          <table class="table table-hover responsive" id="dataTables" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Role</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {% for role in roles %}
              <tr>
                <td>{{role.id}}</td>
                <td>{{role.name}}</td>
                {{ role.active == 'Y' ? '<td class="text-success">active</td>' : '<td class="text-danger">passive</td>' }}
                <td>
                  <div class="btn-group" role="group" aria-label="">
                    {{ link_to("/roles/edit/" ~ role.id, '<i class="fas fa-edit"></i>', "class": "btn btn-primary btn-sm") }}
                    {{ link_to("/roles/editPermission/" ~ role.id, '<i class="fas fa-lock"></i>', "class": "btn btn-warning btn-sm") }}
                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" onclick="delete({{role.id}})"><i class="fas fa-trash-alt"></i></a>
                  </div>
                </td>
              </tr>
              {% endfor %}
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer small text-muted">Updated {{date("Y-m-d H:i:s")}}</div>
    </div>
  </div>
  <!-- /.col-12 -->
</div>
