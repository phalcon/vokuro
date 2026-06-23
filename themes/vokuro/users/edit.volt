<div class="page-head">
    <h1>Edit users</h1>
</div>

<div class="actions">
    {{ link_to('users/index', 'class': 'btn-ghost btn', '&larr; Go Back') }}
</div>

{{ flash.output() }}

<form method="post">
    <div class="card">
        <h3>Basic</h3>
        <div class="field"><label>Name</label>{{ form.render('name', ['class': 'input', 'placeholder': 'Name']) }}</div>
        <div class="field"><label>Profile</label>{{ form.render('profilesId', ['class': 'select']) }}</div>
        <div class="field"><label>E-Mail</label>{{ form.render('email', ['class': 'input']) }}</div>
        <div class="field"><label>Suspended?</label>{{ form.render('suspended', ['class': 'select']) }}</div>
        <div class="field"><label>Banned?</label>{{ form.render('banned', ['class': 'select']) }}</div>
        <div class="field"><label>Confirmed?</label>{{ form.render('active', ['class': 'select']) }}</div>
        {{ form.render("id") }}
        {{ submit_button("Save", "class": "btn") }}
    </div>
</form>

<div class="card">
    <h3>Successful Logins</h3>
    <div class="data-table table-scroll">
        <table>
            <thead><tr><th>Id</th><th>IP Address</th><th>User Agent</th></tr></thead>
            <tbody>
            {% for login in user.successLogins %}
                <tr><td class="id">{{ login.id }}</td><td>{{ login.ipAddress }}</td><td>{{ login.userAgent }}</td></tr>
            {% else %}
                <tr><td colspan="3">User does not have successful logins</td></tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h3>Password Changes</h3>
    <div class="data-table table-scroll">
        <table>
            <thead><tr><th>Id</th><th>IP Address</th><th>User Agent</th><th>Date</th></tr></thead>
            <tbody>
            {% for change in user.passwordChanges %}
                <tr><td class="id">{{ change.id }}</td><td>{{ change.ipAddress }}</td><td>{{ change.userAgent }}</td><td>{{ date("Y-m-d H:i:s", change.createdAt) }}</td></tr>
            {% else %}
                <tr><td colspan="4">User has not changed his/her password</td></tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h3>Reset Passwords</h3>
    <div class="data-table table-scroll">
        <table>
            <thead><tr><th>Id</th><th>Date</th><th>Reset?</th></tr></thead>
            <tbody>
            {% for reset in user.resetPasswords %}
                <tr><td class="id">{{ reset.id }}</td><td>{{ date("Y-m-d H:i:s", reset.createdAt) }}</td><td>{{ reset.reset == 'Y' ? 'Yes' : 'No' }}</td></tr>
            {% else %}
                <tr><td colspan="3">User has not requested reset his/her password</td></tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
