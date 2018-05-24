{{ content() }}

    <div class="row d-flex justify-content-center">
        <div class="col-xl-6  mb-4 mt-4">
            <h1 class="mb-sm-4 pb-sm-2">Sign up</h1>
            {{ form('class': 'form-search') }}

            <div class="form-group row">
                {{ form.label('name', ['class' : 'col-md-3 col-form-label']) }}    
                <div class="col-md-9">
                    {{ form.render('name' , ['class' : 'form-control ']) }}
                    {{ form.messages('name') }}
                </div>
            </div>
            <div class="form-group row">
                {{ form.label('email', ['class' : 'col-md-3 col-form-label']) }}    
                <div class="col-md-9">
                    {{ form.render('email' , ['class' : 'form-control ']) }}
                    {{ form.messages('email') }}
                </div>
            </div>
            <div class="form-group row">
                {{ form.label('password', ['class' : 'col-md-3 col-form-label']) }}    
                <div class="col-md-9">
                    {{ form.render('password', ['class' : 'form-control ']) }}
                    {{ form.messages('password') }}
                </div>
            </div>
            <div class="form-group row">
                {{ form.label('confirmPassword', ['class' : 'col-md-3 col-form-label']) }}    
                <div class="col-md-9">
                    {{ form.render('confirmPassword', ['class' : 'form-control ']) }}
                    {{ form.messages('confirmPassword') }}
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-md-9">
                    {{ form.render('terms') }} 
                    {{ form.label('terms' , ['class': 'col-form-lable']) }}
                    {{ form.messages('terms') }}
                </div>
            </div>


            <div class="form-group row">
                <div class="col-12">
                    {{ form.render('Sign Up', ['class' : 'btn btn-success btn-block']) }}
                </div>
                {{ form.render('csrf', ['value': security.getToken()]) }}
                {{ form.messages('csrf') }}
            </div>

            </form>
        </div>
    </div>