{{ content() }}

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-6 mb-4 mt-4">
            <h1 class="mb-sm-4 pb-sm-2">Change Password</h1>
             
            {{ form("users/changePassword", 'role': 'form', 'auto-complete': 'off') }}
            
                <div class="row form-group">
                    {{ form.label('password', ['class' : 'col-md-3 col-form-lable']) }}
                    <div class="col-sm-9">
                    {{ form.render("password", ['class' : 'form-control'] ) }}
                    </div>
                </div>
                <div class="row form-group">
                    {{ form.label('confirmPassword', ['class' : 'col-md-3 col-form-lable']) }}
                    <div class="col-sm-9">
                    {{ form.render("confirmPassword", ['class' : 'form-control'] ) }}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-12">
                        {{ submit_button("Change Password", "class": "btn btn-primary btn-success btn-block") }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>