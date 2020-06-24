@extends('layout.template')
@section('page-title','Entry')
@section('content')

<!-- Form layouts -->
<div id="app">

<div class="alert bg-warning text-white alert-styled-left alert-dismissible" v-if="searchFlag == 1 && !vehicleDetails.hasOwnProperty('sales_model')">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">Warning!</span> <strong>@{{ csNo }}</strong> not found!
    Reasons why you encouter this issue:
    <ul>
        <li>You have entered an invalid CS No</li>
        <li>You have already submitted a claim for this unit.</li>
        <li>This unit is not affected by Taal's eruption.</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6">

        <!-- Horizontal form -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Vehicle Details</h5>
            </div>

            <div class="card-body">
                <form action="#">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">CS No.</label>
                        <div class="col-lg-8">
                           <div class="input-group">

                                <input v-if="searchFlag == 0" type="text" class="form-control" v-model="csNo" placeholder="Enter CS Number">
                                <input v-if="searchFlag == 1" type="text" class="form-control" readonly="readonly" :value="csNo" placeholder="CS Number">
                                <span class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button" @click="searchVehicle"><i class="icon-search4"></i></button>
                                    <button class="btn btn-danger btn-sm" type="button" @click="clearSearch"><i class="icon-cross3"></i></button>
                                </span>
                            </div>

                         
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Model</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" readonly="readonly" :value="vehicleDetails.model_variant"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Variant</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" readonly="readonly" :value="vehicleDetails.sales_model"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Color</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" readonly="readonly" :value="vehicleDetails.color"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">VIN</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" readonly="readonly" :value="vehicleDetails.vin_no"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Invoice No.</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" readonly="readonly" :value="vehicleDetails.trx_number"/>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Pullout Date</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" readonly="readonly" :value="vehicleDetails.pullout_date"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- /horizotal form -->

        <!-- Horizontal form -->
        <div class="card" v-if="vehicleParts.length > 0">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Replacement Parts</h5>
            </div>

            <div class="card-body">
                <form action="#">
                    <div class="form-group row">
                      
                        <div class="col-lg-8">
                            <div class="form-check" v-for="parts in vehicleParts">
                                <label class="form-check-label">
                                  <input type="checkbox" checked="parts.checked_flag" v-model="parts.checked_flag" class="form-check-input-styled cb_parts" data-fouc="">
                                    @{{ parts.description }}
                                </label>
                            </div>
                        </div>
                    </div>                

                   

                    <div class="text-right">
                        
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-sm btn-light" @click="selectAll">Select All</button>
                        <button type="button" class="btn btn-sm btn-primary" @click="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /horizotal form -->

    </div>

   
</div>

</div>
<!-- /form layouts -->
@stop

@push('scripts')
<script>

    // Defaults
    var swalInit = swal.mixin({
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-light'
    });

    var vm =  new Vue({
        el : "#app",
        data: {
            csNo : '',
            vehicleDetails : [],
            vehicleParts : [],
            searchFlag : 0
        },
        methods :{
            searchVehicle(){ 
                var self = this;

                if(this.csNo == ""){
                    self.vehicleDetails = self.vehicleParts = [];
                    
                    swalInit({
                        title: 'Warning',
                        text: 'Kindly specify the CS Number',
                        type: 'warning',
                        allowEscapeKey: false,
                        allowEnterKey: false
                    });

                    return false;
                }

                self.searchFlag = 0;
                self.blockPage();
                axios.get('vehicle/search/' + this.csNo)
                    .then( (response) => {
                        self.vehicleDetails = response.data;
                        self.searchFlag = 1;
                    })
                    .then( () => {
                        self.vehicleParts = [];
                        if(self.vehicleDetails.hasOwnProperty('sales_model')){
                            self.getParts(self.vehicleDetails.model_id);
                        }
                    })
                   
                    .catch( (error) => {
                        swalInit({
                            title: 'System Error : Get Vehicle Details',
                            text: 'Unexpected error occured! Please contact system developer.',
                            type: 'error',
                            allowEscapeKey: false,
                            allowEnterKey: false
                        });
                    }).finally( () => {
                        self.unblockPage();
                    });
            },
            getParts(modelId){
                var self = this;
                self.vehicleParts = [];
                self.blockPage();
                axios.get('parts/get/' + modelId)
                    .then( (response) => {
                        self.vehicleParts = response.data;
                    })
                    .then( () => {
                        self.selectAll();
                    })
                    .catch( (error) => {
                        swalInit({
                            title: 'System Message',
                            text: 'No part has been registered on ' + self.vehicleDetails.sales_model + ". Please contact Isuzu After Sales.",
                            type: 'warning',
                            allowEscapeKey: false,
                            allowEnterKey: false
                        });
                    })
                    .finally( () => {
                        $('.form-check-input-styled').uniform();
                        self.unblockPage();
                    });
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
            save(){
                var self = this;

                var ctrSelectedParts = 0;
                for(parts of self.vehicleParts){
                    if(parts.checked_flag){ 
                        ctrSelectedParts++;
                    }
                }

                if(ctrSelectedParts == 0){
                    swalInit({
                        title: 'Warning',
                        text: 'Please selected atleast one (1) part',
                        type: 'error',
                        allowEscapeKey: false,
                        allowEnterKey: false
                    });
                    return false;
                }
                
                swalInit({
                    title: 'Are you sure?',
                    text: 'You will not be able to modify changes on this request.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then( (result) => {
                    if(result.value){
                        self.blockPage();
                        axios.post('claim/save',{
                            csNo : self.csNo,
                            parts : self.vehicleParts
                        }).then( (response) => {
                            swalInit({
                                title: 'Claim Submission',
                                text: 'You have succesfully submitted your claim.',
                                type: 'success',
                                allowEscapeKey: false,
                                allowEnterKey: false
                            });

                            self.vehicleDetails = self.vehicleParts = [];
                            self.csNo = "";
                        }).catch( (error) => {
                            swalInit({
                                title: 'System Error : Claim Submission',
                                text: 'Unexpected error occured! Please contact system developer.',
                                type: 'error',
                                allowEscapeKey: false,
                                allowEnterKey: false
                            });
                        }).finally( () => {
                            self.unblockPage();
                            self.searchFlag = 0;
                        });
                    }
                });
            },
            clearSearch() {
                this.vehicleDetails = this.vehicleParts = [];
                this.searchFlag = 0;
                this.csNo = "";
            },
            selectAll(){
                $(".cb_parts").trigger('click');
                for(var i = 0; i < this.vehicleParts.length; i++){
                    this.vehicleParts[i].checked_flag = true;
                }
            }
        },
        created: function () {
            // `this` points to the vm instance
             
        },

        mounted : function () {
           // Initialize plugin
           
        },

        /* watch : {
            csNo: function(val) {
                if(val == ""){
                    this.vehicleParts = this.vehicleDetails = [];
                }
            }
        } */
    
    }); 
</script>
@endpush