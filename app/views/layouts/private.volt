<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
  {{ renderTitle() }}
  {{ stylesheet_link('/css/bootstrap.min.css') }}
  {{ stylesheet_link('/css/dataTables.bootstrap4.min.css') }}
  {{ stylesheet_link('/css/fontawesome.min.css') }}
  {{ stylesheet_link('/css/solid.min.css') }}
  {{ stylesheet_link('/css/my_private.css') }}
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="flex-row d-flex">
      <button type="button" class="navbar-toggler mr-2 " data-toggle="offcanvas" title="Toggle responsive left sidebar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="/dashboard" title="Vokuro">User Panel</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="collapsingNavbar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="/session/logout">Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid" id="main">
    <div class="row row-offcanvas row-offcanvas-left">
      <div class="col-md-3 col-lg-2 sidebar-offcanvas bg-light pl-0" id="sidebar" role="navigation">
        <ul class="nav flex-column sticky-top pl-0 pt-5 mt-3">
          <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="/roles">Roles</a></li>
          <li class="nav-item"><a class="nav-link" href="/users">Users</a></li>
        </ul>
      </div>

      <div class="col main pt-5 mt-3">
        {{ flashSession.output() }}
        {{ content() }}
      </div>

    </div>
  </div>

  <footer class="container-fluid">
    <hr>
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; {{ date("Y") }} Made with love by the Phalcon Team {{ link_to("privacy", "Privacy Policy") }} {{ link_to("terms", "Terms") }}</p>

  </footer>

  {{ javascript_include('/js/jquery-3.3.1.min.js', false) }}
  {{ javascript_include('/js/bootstrap.min.js', false) }}
  {{ javascript_include('/js/bootstrap.bundle.min.js', false) }}
  {{ javascript_include('/js/jquery.dataTables.min.js', false) }}
  {{ javascript_include('/js/dataTables.bootstrap4.min.js', false) }}
  {{ javascript_include('/js/my_private.js', false) }}
  <script type="text/javascript">
  $('#dataTables').dataTable({
    responsive: true,
    stateSave: true,
    autoWidth: true,
    order: [[ 0, 'desc' ]]
  });
  </script>
</body>
