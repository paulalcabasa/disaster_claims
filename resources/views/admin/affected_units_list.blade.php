@extends('layout.template')

@section('page-title','Affected Units')
@section('content')
<!-- Basic table -->
<div id="app">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">IPC Vehicles</h5>
            
        </div>
        <div class="card-body">
        </div>
        <table class="table" id="list">
            <thead>
                <tr>
                    <th>CS No.</th>
                    <th>VIN</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Color</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in list">
                    <td>@{{ row.cs_number }}</td>
                    <td>@{{ row.vin_no }}</td>
                    <td>@{{ row.sales_model }}</td>
                    <td>@{{ row.model_variant }}</td>
                    <td>@{{ row.color }}</td>
                    <td>@{{ row.location }}</td>
                   
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

    
     // Defaults
    var swalInit = swal.mixin({
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-light'
    });

    var vm =  new Vue({
        el : "#app",
        data: {
            list : []
        },
        created: function () {
            var self = this;
            axios.get('vehicle/get-affected-units')
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
           
        }

    });

</script>
@endpush