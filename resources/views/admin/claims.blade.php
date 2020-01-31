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
                        <h3 class="mb-0">@{{ formatNumber(stats.claims) }} / @{{ formatNumber(stats.affected_units) }}</h3>
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
                        <h3 class="mb-0">@{{ formatNumber(unclaimed) }}</h3>
                        <span class="text-uppercase font-size-xs">unclaimed</span>
                    </div>
                    <div class="ml-3 align-self-center">
                        <i class="icon-wrench2 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-info-400 has-bg-image">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-cart5 icon-3x opacity-75"></i>
                    </div>

                    <div class="media-body text-right">
                        <h3 class="mb-0">@{{ formatNumber(stats.invoiced) }}</h3>
                        <span class="text-uppercase font-size-xs">Invoiced</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-indigo-400 has-bg-image">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-coins icon-3x opacity-75"></i>
                    </div>

                    <div class="media-body text-right">
                        <h3 class="mb-0">@{{ stats.retail_sales }}</h3>
                        <span class="text-uppercase font-size-xs">retail sales</span>
                    </div>
                </div>
            </div>
        </div>
       

    </div>
                
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">List of submitted claims </h5>
            
        </div>
       
        <table class="table" id="list">
            <thead>
                <tr>
                    <th>Ref No.</th>
                    <th>Dealer</th>
                    <th>CS No.</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Requested Parts</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($claims as $row)
                <tr>
                    <td>{{ $row->claim_header_id }}</td>
                    <td>{{ $row->account_name }}</td>
                    <td>{{ $row->cs_no }}</td>
                    <td>{{ $row->model }}</td>
                    <td>{{ $row->variant }}</td>
                    <td>{{ $row->parts }}</td>
                    <td>{{ $row->creation_date }}</td>
                    <td class="text-center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item" @click.prevent="viewDetails({{ $row->claim_header_id }})"><i class="icon-file-text"></i> View details</a>
                                 <!--    <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                    <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a> -->
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>

    <!-- Modal with h4 -->
    <div id="infoModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Claim Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body row">

                    <div class="col-md-6">
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

                    <div class="col-md-6">
                         <div class="card border-left-2 border-left-blue-400 rounded-0">
							<div class="card-header">
								<h6 class="card-title">Replacement Parts</h6>
                            </div>
                            
                            <div class="card-body">
                                <ul>
                                    <li v-for="part in curClaim.parts">
                                        @{{ part.description }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    
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
            list : [],
            curClaim : {
                claimDetails : [],
                parts : []
            },
            stats : []
        },
        created: function () {
            this.getStats();
           // this.getClaims();
        },
        mounted : function () {
           // Initialize plugin
           
        },
        computed : {
            unclaimed : function(){
                return parseInt(this.stats.affected_units) - parseInt(this.stats.claims);
            }
        },
        methods :{
            viewDetails(claimHeaderId){
                var self = this;
                axios.get('claims/get/' + claimHeaderId)
                    .then( (response) => {
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
            getStats(){
                var self = this;
                self.blockPage();
                axios.get('claims/stats')
                    .then( (response) => {
                        self.stats = response.data;
                    })
                    .catch( (error) => {
                        console.log(error);
                    })
                    .finally( () => {
                        self.unblockPage();
                    });
            },
            getClaims(){
                var self = this;
                axios.get('claims/get-all')
                    .then( (response) => {
                        self.list = response.data;
                    }).catch( (error) => {
                        console.log(error);
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
            formatNumber(value){
                return Number(value).toLocaleString();//(parseFloat(value).toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
            }
        },
        

    });

</script>
@endpush