{{ content() }}

{{ flash.output() }}

{{ form("relations/create") }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("relations", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>


<div class="row">

    <form accept-charset="utf-8" class="form-horizontal col-md-12 warn-on-exit" method="POST"
          action="http://invoiceninja.local/clients">


        <div class="row">
            <div class="col-md-6">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Organization</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group"><label for="name" class="control-label col-lg-4 col-sm-4">Name</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control"
                                                                  data-bind="attr { placeholder: placeholderName }"
                                                                  id="name" type="text" name="name"></div>
                        </div>
                        <div class="form-group"><label for="id_number" class="control-label col-lg-4 col-sm-4">ID
                                Number</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="id_number" type="text"
                                                                  name="id_number"></div>
                        </div>
                        <div class="form-group"><label for="vat_number" class="control-label col-lg-4 col-sm-4">VAT
                                Number</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="vat_number" type="text"
                                                                  name="vat_number"></div>
                        </div>
                        <div class="form-group"><label for="website"
                                                       class="control-label col-lg-4 col-sm-4">Website</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="website" type="text"
                                                                  name="website"></div>
                        </div>
                        <div class="form-group"><label for="work_phone"
                                                       class="control-label col-lg-4 col-sm-4">Phone</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="work_phone" type="text"
                                                                  name="work_phone"></div>
                        </div>


                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Address</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group"><label for="address1"
                                                       class="control-label col-lg-4 col-sm-4">Street</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="address1" type="text"
                                                                  name="address1"></div>
                        </div>
                        <div class="form-group"><label for="address2"
                                                       class="control-label col-lg-4 col-sm-4">Apt/Suite</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="address2" type="text"
                                                                  name="address2"></div>
                        </div>
                        <div class="form-group"><label for="city" class="control-label col-lg-4 col-sm-4">City</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="city" type="text"
                                                                  name="city"></div>
                        </div>
                        <div class="form-group"><label for="state" class="control-label col-lg-4 col-sm-4">State/Province</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="state" type="text"
                                                                  name="state"></div>
                        </div>
                        <div class="form-group"><label for="postal_code" class="control-label col-lg-4 col-sm-4">Postal
                                Code</label>

                            <div class="col-lg-8 col-sm-8"><input class="form-control" id="postal_code" type="text"
                                                                  name="postal_code"></div>
                        </div>
                        <div class="form-group"><label for="country_id"
                                                       class="control-label col-lg-4 col-sm-4">Country</label>

                            <div class="col-lg-8 col-sm-8">#</div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Contacts</h3>
                    </div>
                    <div class="panel-body">

                        <div data-bind='template: { foreach: contacts,
		                            beforeRemove: hideContact,
		                            afterAdd: showContact }'>
                            <div class="form-group"><label for="first_name" class="control-label col-lg-4 col-sm-4">First
                                    Name</label>

                                <div class="col-lg-8 col-sm-8"><input class="form-control"
                                                                      data-bind="value: first_name"
                                                                      id="first_name" type="text" name="first_name">
                                </div>
                            </div>
                            <div class="form-group"><label for="last_name" class="control-label col-lg-4 col-sm-4">Last
                                    Name</label>

                                <div class="col-lg-8 col-sm-8"><input class="form-control"
                                                                      data-bind="value: last_name"
                                                                      id="last_name" type="text" name="last_name"></div>
                            </div>
                            <div class="form-group"><label for="email"
                                                           class="control-label col-lg-4 col-sm-4">Email</label>

                                <div class="col-lg-8 col-sm-8"><input class="form-control"
                                                                      data-bind="value: email"
                                                                      id="email" type="email" name="email"></div>
                            </div>
                            <div class="form-group"><label for="phone"
                                                           class="control-label col-lg-4 col-sm-4">Phone</label>

                                <div class="col-lg-8 col-sm-8"><input class="form-control"
                                                                      data-bind="value: phone"
                                                                      id="phone" type="text" name="phone"></div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4 bold">
						<span class="redlink bold" data-bind="visible: $parent.contacts().length > 1">
							<a href="#" data-bind="click: $parent.removeContact">Remove contact -</a>
						</span>
						<span data-bind="visible: $index() === ($parent.contacts().length - 1)"
                              class="pull-right greenlink bold">
							<a href="#" onclick="return addContact()">Add contact +</a>
						</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Additional Info</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group"><label for="currency_id" class="control-label col-lg-4 col-sm-4">Currency</label>

                            <div class="col-lg-8 col-sm-8">#</div>
                        </div>
                        <div class="form-group"><label for="language_id" class="control-label col-lg-4 col-sm-4">Language</label>

                            <div class="col-lg-8 col-sm-8">#</div>
                        </div>
                        <div class="form-group"><label for="payment_terms" class="control-label col-lg-4 col-sm-4">Payment
                                Terms</label>

                            <div class="col-lg-8 col-sm-8">#<span
                                        class="help-block">Sets the default invoice due date</span></div>
                        </div>
                        <div class="form-group"><label for="size_id" class="control-label col-lg-4 col-sm-4">Company
                                Size</label>

                            <div class="col-lg-8 col-sm-8">#</div>
                        </div>
                        <div class="form-group"><label for="industry_id" class="control-label col-lg-4 col-sm-4">Industry</label>

                            <div class="col-lg-8 col-sm-8">#</div>
                        </div>
                        <div class="form-group"><label for="private_notes" class="control-label col-lg-4 col-sm-4">Private
                                Notes</label>

                            <div class="col-lg-8 col-sm-8"><textarea class="form-control" id="private_notes"
                                                                     name="private_notes"></textarea></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <input class="form-control" data-bind="value: ko.toJSON(model)" type="hidden" name="data" value="">

        <a class='btn btn-default btn-lg' href='http://invoiceninja.local/clients'>Cancel <span
                    class='glyphicon glyphicon-remove-circle'></span></a>
        <button type='submit' class='btn btn-success btn-lg'>Save <span
                    class='glyphicon glyphicon-floppy-disk'></span></button>


        <input class="form-control" type="hidden" name="_token" value="M7Y1yv39o2iU7vNzOopAHn9cUuayVFlwRlDJip9k"></form>
</div>




