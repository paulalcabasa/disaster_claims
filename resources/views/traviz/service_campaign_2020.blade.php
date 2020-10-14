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
	<script src="{{ asset('global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>

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
                            <h4><span class="font-weight-semibold">Traviz Service Campaign 2020</span></h4>
                            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                        </div>
                    </div>
                </div>


                <!-- Content area -->
                <div class="content pt-0">

                    <div class="alert bg-dark alert-dismissible" v-show="flag.exist">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation. 
                        Based on the vehicle details you provided Your Isuzu Traviz
                        has already been checked.
                    </div>

                    <!-- <div class="alert bg-danger text-white alert-dismissible" v-show="flag.notFound">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation. The vehicle information you have provided is not included
                        in the Service Campaign for Isuzu Traviz.
                    </div>

                    <div class="alert bg-danger text-white alert-dismissible" v-show="flag.notFound">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation. 
                        The information you provided are not valid vehicle details for Isuzu Traviz. 
                        Kindly check the details and you may try again.
                    </div> -->

                    <div class="alert bg-danger text-white alert-dismissible" v-show="flag.notFound">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation. The vehicle information you have provided is not included
                        in the Service Campaign for Isuzu Traviz. Kindly check the details and you may try again.
                    </div>

                    <div class="alert bg-light  alert-dismissible" v-show="flag.found">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for your cooperation.
                        The details you provided are important to us. 
                        You may contact your nearest Isuzu dealer to make the necessary arrangement 
                        for your appointment or you may wish to encode your contact details below so 
                        our Customer Representatives can get in touch with you.
                    </div>

                    <div class="alert bg-light  alert-dismissible" v-show="flag.success">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        Thank you for providing us the information. 
                        The details you provided are important to us.
                        Kindly expect a call or email from our Isuzu Authorized Dealer regarding this matter.
                    </div>

                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h5 class="card-title">Vehicle Details</h5>
                                </div>
                                <div class="card-body">
                                    <form v-on:submit.prevent="findVehicle">
                                        <div class="form-group row">
                                            <div class="col-sm-8">
                                                <input type="text" required class="form-control" v-model="searchParam" placeholder="Search by CS Number, VIN Engine or Chassis Number">
                                            </div>
                                            <div class="col-sm-4">
                                                <button type="submit"  class="btn bg-blue ml-3">FIND <i class="icon-search4 ml-2"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <div v-show="flag.found">        
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
                                            <label class="col-form-label col-md-3">Selling Dealer</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control font-weight-light" placeholder="" readonly="readonly" :value="vehicle.customer_name + ' - ' + vehicle.account_name" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                
                        </div>
                        <div class="col-md-6">
                            <div class="card" v-show="flag.found">
                                <div class="card-header header-elements-inline">
                                    <h5 class="card-title">Contact Us</h5>
                                    
                                </div>
                                <div class="card-body">
                                    <form v-on:submit.prevent="submitInquiry">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Registered owner <span class="text-danger">*</span> </label>
                                            <div class="col-md-9">
                                                <input type="text" required class="form-control font-weight-light" placeholder="Please input the registed owner" v-model="inquiry.registered_owner" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Contact person <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" required class="form-control font-weight-light" placeholder="Please type in the contact person" v-model="inquiry.contact_person"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Contact number <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" required class="form-control font-weight-light" placeholder="Please type in the contact number" v-model="inquiry.contact_number" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Email address <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="email" required class="form-control font-weight-light" placeholder="Please type in the email address" v-model="inquiry.email_address"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">Preferred Isuzu Servicing Dealer <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <select required class="form-control" id="preferred_servicing_dealer" v-model="inquiry.preferred_servicing_dealer" v-select2>
                                                    <option value="">Select dealer</option>
                                                    <option v-for="dealer in dealers" :value="dealer.id">Isuzu @{{ dealer.account_name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row ml-5 mr-5">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" v-model="inquiry.dpa_flag" class="form-check-input-styled" data-fouc="">
                                                    I confirm giving my consent, and that I have read, understood, and agree to Isuzu Philippine's <a target="_blank" href="https://www.isuzuphil.com/about/privacy-policy">Privacy Policy.</a>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="text-right">
											<button v-show="inquiry.dpa_flag" type="submit" class="btn btn-danger">Send message</button>
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

Vue.directive('select2', {
    inserted(el) {
        $(el).on('select2:select', () => {
            const event = new Event('change', { bubbles: true, cancelable: true });
            el.dispatchEvent(event);
        });

        $(el).on('select2:unselect', () => {
            const event = new Event('change', {bubbles: true, cancelable: true})
            el.dispatchEvent(event)
        })
    },
});

var vm =  new Vue({
    el : "#app",
    data: {
        dealers : {!! json_encode($dealers) !!},
        searchParam : '',
        vehicle : {
            cs_no : '',
            vin : '',
            engine_no : '',
            account_name : '',
            customer_mname : ''
        },
        inquiry : {
            registered_owner : '',
            contact_number : '',
            contact_person : '',
            email : '',
            preferred_servicing_dealer : '',
            dpa_flag : false
        },
        flag : {
            notFound : false,
            found : false,
            exist : false,
            success : false,
        }
    
    },
    created: function () {
        
    },
    mounted : function () {
        $('.form-check-input-styled').uniform();
        $('#preferred_servicing_dealer').select2();
    },
    updated() {
        
    },
    methods : {
        findVehicle(){
            this.resetForm();
            this.blockPage();
            axios.get('api/traviz/get-details/' + this.searchParam).then(response => {
                if(response.data != ""){
                    this.flag.found = true;
                    this.vehicle = response.data;
                }
                else {
                    this.flag.notFound = true;
                }
            }).catch(error => {
                console.log(error);
            }).finally( () => {
                this.unblockPage();
            });
        },
        resetForm(){
            this.flag.notFound = false;
            this.flag.exist = false;
            this.flag.success = false;
            this.flag.found = false;
            this.vehicle.cs_no = "";
            this.vehicle.vin = "";
            this.vehicle.engine_no = "";
            this.vehicle.customer_name = "";
            this.vehicle.account_name = "";
        },
        blockPage() {
            $.blockUI({ 
                message: '<i class="icon-spinner4 spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        },
        unblockPage(){
            $.unblockUI();
        },
        submitInquiry(){
            this.blockPage();
            axios.post('api/inquiry/submit', {
                inquiry : this.inquiry,
                vehicle : this.vehicle
            }).then(response => {
                if(response.data.status == "success"){
                    this.resetForm();
                    this.searchParam = "";
                    this.flag.success = true;
                }
            }).then(error => {
                console.log(error);
            }).finally(() => {
                this.unblockPage();
            });

        }
    }


});

</script>
