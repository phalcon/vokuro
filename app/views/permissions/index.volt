
{{ content() }}

{{ form('role': 'form') }}
<div class="row d-flex justify-content-center">
    <div class="col-md-8  mb-4 mt-4">
        <h2 class="mb-sm-6 pb-sm-2">Manage permissions</h2>  

                   <div class="row mt-4 form-group justify-content-center">
                        <label class="mr-4 col-form-label text-center" for="profileId">Profile</label>
                        <div class="mr-4">
			    {{ select('profileId', profiles, 'using': ['id', 'name'], 'useEmpty': true, 'emptyText': '...', 'emptyValue': '', 'class' : 'form-control mb-2 mb-sm-0') }}
                        </div>
                        <div class="">
		            {{ submit_button('Search', 'class': 'btn btn-primary', 'name' : 'search') }}
                        </div>
                    </div>
                      
{% if request.isPost() and profile %}

{% for resource, actions in acl.getResources() %}

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
			
{% endfor %}

{{ submit_button('Submit', 'class': 'btn btn-primary', 'name':'submit') }}   

{% endif %}

</form>
