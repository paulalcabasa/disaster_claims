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
                <tr v-for="row in list">
                    <td>@{{ row.claim_header_id }}</td>
                    <td>@{{ row.cs_no }}</td>
                    <td>@{{ row.model }}</td>
                    <td>@{{ row.variant }}</td>
                    <td>@{{ row.creation_date }}</td>
                    <td class="text-center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item" @click.prevent="viewDetails(row.claim_header_id)"><i class="icon-file-text"></i> View details</a>
                                 <!--    <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                    <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a> -->
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table> 
    </div>
</div>
<!-- /basic table -->

<!-- /form layouts -->
@stop

@push('scripts')
<script>

    

    var vm =  new Vue({
        el : "#app",
        data: {
            list : []
        },
        created: function () {
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
        mounted : function () {
           // Initialize plugin
           
        },
        methods :{
            viewDetails(claimHeaderId){
                axios.get('claims/get/' + claimHeaderId)
                    .then( (response) => {
                        console.log(response.data);
                    });
            }
        }

    });

</script>
@endpush