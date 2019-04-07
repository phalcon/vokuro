<h1>Users</h1>
<hr>
<div class="row mb-3">
  <div class="col-12">
    {{ content() }}
    <div class="card">
      <div class="card-header">
        <h4>User - {{user.name}}</h4>
      </div>
      <div class="row">
        <div class="card-body">
          <table class="table table-hover responsive" id="dataTables" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>IP</th>
                <th>Agent</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              {% for login in user.successLogins %}
              <tr>
                <td>{{ login.id }}</td>
                <td>{{ login.ipAddress }}</td>
                <td>{{ login.userAgent }}</td>
                <td>{{ login.date }}</td>
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
