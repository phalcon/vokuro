<h1>Roles</h1>
<hr>
<div class="row mb-3">
	<div class="col-12">
		{{ content() }}
		{% if role %}
		<div class="card">
			<div class="card-header">
				<h4>Manage permissions - {{role.name}}</h4>
			</div>
			<div class='row'>
				<div class="card-body">
					<div class='col-lg-12 col-md-12 col-sm-12 '>
						{{ form() }}
						<div class='row'>
							{% for resource, actions in acl.getResources() %}
							<div class='col-lg-6 col-md-6 col-sm-6'>
								<h3>{{ resource }}</h3>
								<table class="table table-bordered table-striped" align="center">
									<thead>
										<tr>
											<th width="5%"></th>
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
										{% for action in actions %}
										<tr>
											<td align="center"><input type="checkbox" name="permissions[]" value="{{ resource ~ '.' ~ action }}"  {% if permissions[resource ~ '.' ~ action] is defined %} checked="checked" {% endif %}></td>
											<td>{{ acl.getActionDescription(action) ~ ' ' ~ resource }}</td>
										</tr>
										{% endfor %}
									</tbody>
								</table>
							</div>
							{% endfor %}
						</div>
						<div class="btn-group">
							{{ submit_button('Submit', 'class': 'btn btn-success', 'value':'Save') }}
							{{ link_to("/roles", 'Cancel', "class": "btn btn-warning") }}
						</div>
						{% endif %}
						{{ end_form() }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.col-12 -->
</div>
