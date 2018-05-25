{{ content() }}

<div class="row">
    <div class="col-6">
        {{ link_to("profiles", '<span class="oi oi-chevron-left" title="chevron-left" aria-hidden="true"></span> Go Back', "class": "btn btn-outline-primary") }}
    </div>
    <div class="col-6 text-right">
    </div>
</div>

<div class="row d-flex justify-content-center">
    <div class="col-xl-6  mb-4 mt-4">
        <h2 class="mb-sm-6 pb-sm-2">Create a Profile</h2>        
        {{ form("profiles/create", 'role': 'form', 'autocomplete' : 'off') }}

        <div class="form-group row">
            {{ form.label('name', ['class' : 'col-md-3 col-form-label']) }}    
            <div class="col-md-9">
                {{ form.render('name' , ['class' : 'form-control ']) }}
            </div>
        </div>

        <div class="form-group row">
            {{ form.label('active', ['class' : 'col-md-3 col-form-label']) }}    
            <div class="col-md-9">
                {{ form.render('active' , ['class' : 'form-control ']) }}
            </div>
        </div>
        <div class="form-group row justify-content-end">
            <div class="col-md-9" >
                {{ submit_button("Save", "class": "btn btn-success btn-block") }}
            </div>
        </div>
        </form>    
    </div>
</div>
