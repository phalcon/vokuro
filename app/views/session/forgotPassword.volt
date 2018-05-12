{{ content() }}

            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-4 mb-4 mt-4">
                        <h1 class="mb-sm-6 pb-sm-2">Forgot Password ? </h1>
                        {{ form('class': 'form-search ') }}
                        <div class="input-group">
                            {{ form.render('email', ['class': 'form-control']) }}
                            <div class="input-group-append">
                                {{ form.render('Send', ['class' : 'btn btn-success']) }}
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>