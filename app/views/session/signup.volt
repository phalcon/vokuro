<div class="d-flex justify-content-center">
	<div class="col-md-6">
		<div class="card-body">
			<h3 class="text-center">Sign up</h3>
			{{ content() }}
			{{ form('class': 'form-search') }}
			<div class="form-group">
				<label class="control-label">Name</label>
				{{ form.render('name') }}
			</div>
			<div class="form-group">
				<label class="control-label">E-Mail</label>
				{{ form.render('email') }}
			</div>
			<div class="form-group">
				<label class="control-label">Password</label>
				{{ form.render('password') }}
			</div>
			<div class="form-group">
				<label class="control-label">Confirm Password</label>
				{{ form.render('confirmPassword') }}
			</div>
			<div align="center">
				{{ form.render('terms') }} {{ form.label('terms') }}
			</div>
			{{ form.render('Sign Up') }}
			{{ form.render('csrf', ['value': security.getToken()]) }}
		</form>
	</div>
</div>
</div>
