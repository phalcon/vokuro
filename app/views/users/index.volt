<h1>Users</h1>
<hr>
<div class="row mb-3">
  <div class="col-12">
    {{ content() }}
    <div class="card">
      <div class="card-header">
        {{ link_to("users/create", "Add User", "class": "btn btn-primary btn-sm") }}
      </div>

      <div class="card-body">
        <div class="row">
          <table class="table table-hover responsive" id="dataTables" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Email</th>
                <th>name</th>
                <th>role</th>
                <th>status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {% for user in users %}
              <tr>
                <td>{{ user.id }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.role.name }}</td>
                {{ user.active == 'Y' ? '<td class="text-success">Active</td>' : '<td class="text-danger">Passive</td>' }}
                <td>
                  <div class="btn-group" role="group" aria-label="">
                    <a href="/users/edit/{{ user.id }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="/users/authorization/{{ user.id }}" class="btn btn-warning btn-sm"><i class="fas fa-sign-in-alt"></i></a>
                    <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" onclick="delete({{user.id}})"><i class="fas fa-trash-alt"></i></a>
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
