<div class="d-flex justify-content-center">
	<div class="col-md-6">
		<div class="card-body">
			<h3 class="text-center">Forgot Password?</h3>
			{{ content() }}
			{{ form('class': 'form-search') }}
			<div class="form-group">
				<label class="control-label">E-Mail</label>
				{{ form.render('email') }}
			</div>
			{{ form.render('Send') }}
		</form>
	</div>
</div>
</div>
