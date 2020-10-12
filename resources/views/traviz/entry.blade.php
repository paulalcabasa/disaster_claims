<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Isuzu Customer Support Monitoring</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/ui/ripple.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/inputs/touchspin.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>

	<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
	<!-- Theme JS files -->

	<script src="{{ asset('assets/js/app.js') }}"></script>
	
	<script src="{{ asset('public/js/app.js') }}"></script>
	
	<!-- /theme JS files -->

</head>
<body>
    <div class="content mt-15" id="app">
        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <div class="page-header">
                    <div class="page-header-content header-elements-md-inline">
                        <div class="page-title d-flex">
                            <h4><span class="font-weight-semibold">Isuzu Traviz Service Campaign</span></h4>
                            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                        </div>
                    </div>
                </div>


                <!-- Content area -->
                <div class="content pt-0">

                    <div class="alert bg-info text-white alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation. 
                        Based on the vehicle details you provided Your Isuzu Traviz has already been checked.
                    </div>
                    <div class="alert bg-danger text-white alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation.
                        The details you provided are not valid vehicle details for Isuzu Traviz.
                        Kindly check the details and you may try again.
                    </div>
                    <div class="alert bg-success text-white alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation.
                        The details you provided are important to us. 
                        You may contact your nearest Isuzu dealer to make the necessary arrangement 
                        for your appointment or you may wish to encode your contact details below so 
                        our Customer Representatives can get in touch with you.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h5 class="card-title">Vehicle Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" placeholder="Search by CS Number, VIN Engine or Chassis Number">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn bg-blue ml-3">FIND <i class="icon-search4 ml-2"></i></button>
                                        </div>
								    </div>

                                
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">VIN</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control font-weight-light" placeholder="" readonly="readonly" :value="vehicle.vin" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">CS No.</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control font-weight-light" placeholder="" readonly="readonly" :value="vehicle.cs_no" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Engine</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control font-weight-light" placeholder="" readonly="readonly" :value="vehicle.engine_no"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Sales Model</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control font-weight-light" placeholder="" readonly="readonly" :value="vehicle.sales_model"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Color</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control font-weight-light" placeholder="" readonly="readonly" :value="vehicle.color" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Dealer</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control font-weight-light" placeholder="" readonly="readonly" :value="vehicle.dealer" />
                                        </div>
                                    </div>
            
                                </div>
                            </div>  
                
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h5 class="card-title">Contact Us</h5>
                                    
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Registered owner</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control font-weight-light" placeholder="Please input the registed owner" v-model="contact.registered_owner" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Contact person</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control font-weight-light" placeholder="Please type in the contact person" v-model="contact.contact_person"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Contact number</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control font-weight-light" placeholder="Please type in the contact number" v-model="contact.contact_number" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Email address</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control font-weight-light" placeholder="Please type in the email address" v-model="contact.email_address"/>
                                            </div>
                                        </div>
                                        <div class="text-right">
											<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
										</div>
                                    </form>
                                </div>
                            </div>  
                
                        </div>
                    </div>
                   
                        
                </div>
                <!-- /content area -->
            </div>
            <!-- /main content -->
        </div>
	    <!-- /page content -->
	</div>
</body>
</html>

<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            vehicle : {
                cs_no : '',
                vin : '',
                engine_no : '',
                sales_model : '',
                color : '',
                dealer : ''
            },
            contact : {
                registered_owner : '',
                contact_number : '',
                contact_person : '',
                email : ''
            }
        
        },
        created: function () {
            
        },
        mounted : function () {
           
           
        },
        updated() {
          

        },

    
    });

</script>
