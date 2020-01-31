@extends('layout.template')

@section('page-title','Claims')
@section('content')
<!-- Basic table -->
<div id="app">

    
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">List of submitted claims </h5>
            
        </div>
        <div class="card-body">
        </div>
        <table class="table" id="list">
            <thead>
                <tr>
                    <th>Ref No.</th>
                    <th>CS No.</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($claims as $row)
                <tr>
                    <td>{{ $row->claim_header_id }}</td>
                    <td>{{ $row->cs_no }}</td>
                    <td>{{ $row->model }}</td>
                    <td>{{ $row->variant }}</td>
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
            //list : {!! json_encode($claims) !!},
            curClaim : {
                claimDetails : [],
                parts : []
            }
        },
        created: function () {
            
        },
        mounted : function () {
           // Initialize plugin
           
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
            }
        }

    });

</script>
@endpush