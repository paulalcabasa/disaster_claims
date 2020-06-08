@extends('layout.template')

@section('page-title','Chrome Matrix')
@section('content')
<!-- Basic table -->
<div id="app">

   

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Chrome Matrix</h5>
            
        </div>
        <div class="card-body">
        </div>
        <table class="table" id="list">
            <thead>
                <tr>
                    <th v-for="row in header">@{{ row }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in chrome_matrix">
                    <td v-for="data in row">@{{ data }}</td>
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
            header : {!! json_encode($header) !!},
            chrome_matrix : {!! json_encode($chrome_matrix) !!}
        },
        created: function () {
            
        },
        mounted : function () {
           // Initialize plugin
           console.log(this.chrome_matrix);
        },
        methods :{
          
          
        }

    });

</script>
@endpush