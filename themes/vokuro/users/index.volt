<h1 class="mt-3">Search users</h1>

<div class="mb-5">
    {{ link_to("users/create", "Create Users", "class": "btn btn-primary") }}
</div>
<h6 id="usersAssetManagerDemoTextContainer">Separated javascript has been loaded</h6>

{{ flash.output() }}

<form class="form-inline" method="get" action="{{ url("users/search") }}">
    <div class="form-group">
        <label for="id" class="sr-only">Id</label>
        {{ form.render('id', ['class': 'form-control mr-sm-2', 'placeholder': 'Id']) }}
    </div>

    <div class="form-group">
        <label for="name" class="sr-only">Name</label>
        {{ form.render('name', ['class': 'form-control mr-sm-2', 'placeholder': 'Name']) }}
    </div>

    <div class="form-group">
        <label for="email" class="sr-only">Email</label>
        {{ form.render('email', ['class': 'form-control mr-sm-2']) }}
    </div>

    <div class="form-group">
        {{ form.render('profilesId', ['class': 'form-control mr-sm-2']) }}
    </div>

    <button type="submit" class="btn btn-primary">Search</button>
</form>
