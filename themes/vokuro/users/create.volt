<div class="page-head">
    <h1>Create a User</h1>
</div>

<div class="actions">
    {{ link_to('users', 'class': 'btn-ghost btn', '&larr; Go Back') }}
</div>

{{ flash.output() }}

<div class="card">
    <form method="post">
        <div class="field">
            <label for="name">Name</label>
            {{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}
        </div>

        <div class="field">
            <label for="email">E-Mail</label>
            {{ form.render('email', ['class': 'input', 'placeholder': 'E-Mail']) }}
        </div>

        <div class="field">
            <label for="profilesId">Profile</label>
            {{ form.render('profilesId', ['class': 'select']) }}
        </div>

        {{ submit_button("Save", "class": "btn") }}
    </form>
</div>
