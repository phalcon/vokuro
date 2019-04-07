<div class="d-flex justify-content-center">
	<div class="col-md-6">
		<div class="card-body">
			<h3 class="text-center">Login</h3>
			{{ content() }}
			{{ form('class': 'form-search') }}
			<div class="form-group">
				<label class="control-label">E-Mail</label>
				{{ form.render('email') }}
			</div>
			<div class="form-group">
				<label class="control-label">Password</label>
				{{ form.render('password') }}
			</div>
			<div align="center">
				{{ form.render('remember') }}
				{{ form.label('remember') }}
			</div>
			{{ form.render('go') }}
			{{ form.render('csrf', ['value': security.getToken()]) }}
		</form>
	</div>
</div>
</div>
