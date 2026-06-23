<div class="page-head">
    <h1>Create a Profile</h1>
</div>

{{ flash.output() }}

<div class="actions">
    {{ link_to('profiles', 'class': 'btn-ghost btn', '&larr; Go Back') }}
</div>

<div class="card">
    <form method="post">
        <div class="field">
            {{ form.label('name') }}
            {{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}
        </div>

        <div class="field">
            <label for="active">Active?</label>
            {{ form.render('active', ['class': 'select']) }}
        </div>

        {{ submit_button("Save", "class": "btn") }}
    </form>
</div>
