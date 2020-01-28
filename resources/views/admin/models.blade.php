@extends('layout.template')

@section('page-title','Models and Parts')
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
                    <th>Model</th>
                    <th>Part Description</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in list">
                    <td>@{{ row.model_name }}</td>
                    <td>@{{ row.part_description }}</td>
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
            axios.get('models/get')
                .then( (response) => {
                    self.list = response.data;
                }).catch( (error) => {
                    console.log(error);
                }).finally( () => {
                    
                    // Setting datatable defaults
                    $.extend( $.fn.dataTable.defaults, {
                        autoWidth: false,

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