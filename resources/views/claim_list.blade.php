@extends('layout.template')

@section('page-title','Claims')
@section('content')
<!-- Basic table -->
<div id="app">

        <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-success-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">@{{ stats.original.claims }}</h3>
                        <span class="text-uppercase font-size-xs">claimed</span>
                    </div>
                    <div class="ml-3 align-self-center">
                        <i class="icon-thumbs-up2  icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-danger-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">@{{ (stats.original.affected_units -  stats.original.claims) }}</h3>
                        <span class="text-uppercase font-size-xs">unclaimed</span>
                    </div>
                    <div class="ml-3 align-self-center">
                        <i class="icon-wrench2 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">List of submitted claims </h5>
            
        </div>
        <div class="card-body">
        </div>
        <table class="table" id="list" >
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Status</th>
                    <th>Ref No.</th>
                    <th>CS No.</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Requested Parts</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>

      

                <tr v-for="(row,index) in claims">
                    <td class="text-center">
                        <a href="#"  @click.prevent="viewDetails(row,index)"><i class="icon-search4"></i></a>
                    </td>
                    <td>@{{ row.status }}</td>
                    <td>@{{ row.claim_header_id }}</td>
                    <td>@{{ row.cs_no }}</td>
                    <td>@{{ row.model }}</td>
                    <td>@{{ row.variant }}</td>
                    <td>@{{ row.parts }}</td>
                    <td>@{{ row.creation_date }}</td>
                    
                </tr>
           
            </tbody>
        </table> 
    </div>

    <!-- Modal with h4 -->
    <div id="infoModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Claim Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body row">
                    <div class="col-md-5">
                        <div class="card border-left-2 border-left-blue-400 rounded-0">
							<div class="card-header">
								<h6 class="card-title">Vehicle Details</h6>
							</div>
							
							<div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Ref No.</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" readonly="readonly" :value="curClaim.claimDetails.claim_header_id"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">CS No.</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" readonly="readonly" :value="curClaim.claimDetails.cs_no"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Variant</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" readonly="readonly" :value="curClaim.claimDetails.variant"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Model</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" readonly="readonly" :value="curClaim.claimDetails.model"/>
                                    </div>
                                </div>
							</div>
                        </div>
                    
                    </div>  

                    <div class="col-md-7">
                         <div class="card border-left-2 border-left-blue-400 rounded-0">
							<div class="card-header">
								<h6 class="card-title">Replacement Parts</h6>
                            </div>
                            
                            <div class="card-body">
                                <ul v-show="curHeader.status == 'submitted'">
                                    <li v-for="part in curClaim.parts">
                                        @{{ part.description }}
                                    </li>
                                </ul>
                               <form>
                                <div class="form-group row" v-show="curHeader.status == 'pending'">

                                    <div class="col-lg-12">
                                        <div class="form-check" v-for="parts in curClaim.parts">
                                            <label class="form-check-label">
                                            <input type="checkbox"  checked="parts.available_flag" v-model="parts.available_flag" class="form-check-input-styled" data-fouc="">
                                                @{{ parts.description }}
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                </form>  
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="save" v-show="curHeader.status == 'pending'">Save</button>
                    <button type="button" class="btn btn-success" @click="submit" v-show="curHeader.status == 'pending'">Submit</button>  
                </div>
            </div>
        </div>
    </div>
    <!-- /modal with h4 -->
                
</div>
<!-- /basic table -->

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

     var DatatableButtonsHtml5 = function() {


        //
        // Setup module components
        //

        // Basic Datatable examples
        var _componentDatatableButtonsHtml5 = function() {
            if (!$().DataTable) {
                console.warn('Warning - datatables.min.js is not loaded.');
                return;
            }

            // Setting datatable defaults
            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                }
            });


            // Basic initialization
            $('#list').DataTable({
                buttons: {            
                    dom: {
                        button: {
                            className: 'btn btn-light'
                        }
                    },
                    buttons: [
                        'excelHtml5',
                        'csvHtml5',
                    ]
                },
                scrollX : true
            });

        };

        // Select2 for length menu styling
        var _componentSelect2 = function() {
            if (!$().select2) {
                console.warn('Warning - select2.min.js is not loaded.');
                return;
            }

            // Initialize
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                dropdownAutoWidth: true,
                width: 'auto'
            });
        };


        //
        // Return objects assigned to module
        //

        return {
            init: function() {
                _componentDatatableButtonsHtml5();
                _componentSelect2();
            }
        }
    }();

        // Initialize module
    // ------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        DatatableButtonsHtml5.init();
    });




    var vm =  new Vue({
        el : "#app",
        data: {
            stats : {!! json_encode($stats)!!},
            curClaim : {
                claimDetails : [],
                parts : []
            },
            curHeader : {},
            claims : {!! json_encode($claims) !!},
            curRowIndex : 0
        
        },
        created: function () {
            
        },
        mounted : function () {
           // Initialize plugin
           
        },
        updated() {
            $('.form-check-input-styled').uniform();
            $('.form-input-styled').uniform({
                fileButtonClass: 'action btn bg-warning-400'
            });

        },

        methods :{
            viewDetails(row,index){
                var self = this;
                self.curRowIndex = index;
                axios.get('claims/get/' + row.claim_header_id)
                    .then( (response) => {
                        self.curHeader = row;
                        self.curClaim = response.data;
                    })
                    .then( () => {
                        $("#infoModal").modal('show');
                    })
                    .catch( (error) => {
                        swalInit({
                            title: 'System Error : View claim details',
                            text: 'Unexpected error occured! Please contact system developer.',
                            type: 'error',
                            allowEscapeKey: false,
                            allowEnterKey: false
                        });
                    })
                    .finally( () => {

                    });
            },
            getClaims(){
                var self = this;
                axios.get('claims/get')
                    .then( (response) => {
                        self.list = response.data;
                    }).catch( (error) => {
                        alert("Unexpected error occured!");
                    }).finally( () => {
                        
                        // Setting datatable defaults
                        $.extend( $.fn.dataTable.defaults, {
                            autoWidth: false,
                            columnDefs: [{ 
                                orderable: false,
                                width: 100,
                                targets: [ 5 ]
                            }],
                            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                            language: {
                                search: '<span>Filter:</span> _INPUT_',
                                searchPlaceholder: 'Type to filter...',
                                lengthMenu: '<span>Show:</span> _MENU_',
                                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                            }
                        });

                        // Basic datatable
                        $('#list').DataTable();

                        // Alternative pagination
                        $('.datatable-pagination').DataTable({
                            pagingType: "simple",
                            language: {
                                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                            }
                        });
                        // Datatable with saving state
                        $('.datatable-save-state').DataTable({
                            stateSave: true
                        });

                        // Scrollable datatable
                    /*    var table = $('.datatable-scroll-y').DataTable({
                            autoWidth: true,
                            scrollY: 300
                        }); */

                        // Resize scrollable table when sidebar width changes
                        $('.sidebar-control').on('click', function() {
                            table.columns.adjust().draw();
                        });

                        // Initialize
                        $('.dataTables_length select').select2({
                            minimumResultsForSearch: Infinity,
                            dropdownAutoWidth: true,
                            width: 'auto'
                        });

                    });
            },
            submit(){
                var self = this;
                swalInit({
                    title: 'Are you sure?',
                    text: 'You will not be able to modify changes on this request.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then( (result) => {
                    if(result.value){
                        axios.post('claims/submit',{
                            claim : self.curHeader
                        }).then( (response) => {
                            swalInit({
                                title: 'Claim Submission',
                                text: 'You have succesfully submitted your claim.',
                                type: 'success',
                                allowEscapeKey: false,
                                allowEnterKey: false
                            });
                            self.claims[self.curRowIndex].status = 'submitted';
                        }).catch( (error) => {
                            swalInit({
                                title: 'System Error : Claim Submission',
                                text: 'Unexpected error occured! Please contact system developer.',
                                type: 'error',
                                allowEscapeKey: false,
                                allowEnterKey: false
                            });
                        });
                    }
                });
            },
            save(){
                var self = this;
                axios.post('claims/update',{
                        header : self.curHeader,
                        parts : self.curClaim.parts
                    }).then( (response) => {
                        swalInit({
                            title: 'Claim Update',
                            text: 'You have succesfully updated your claim.',
                            type: 'success',
                            allowEscapeKey: false,
                            allowEnterKey: false
                        });
                    }).catch( (error) => {
                        swalInit({
                            title: 'System Error : Claim Submission',
                            text: 'Unexpected error occured! Please contact system developer.',
                            type: 'error',
                            allowEscapeKey: false,
                            allowEnterKey: false
                        });
                    });
            }
        }

    });

</script>
@endpush