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
        <table class="table datatable-button-html5-basic" id="list">
            <thead>
                <tr>
                    <th>CS No.</th>
                    <th>VIN</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Color</th>
                    <th>Location</th>
                    <th>Pullout Date</th>
                    <th>Invoiced To</th>
                    <th>Retail Sale Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $unit)
                <tr>
                    <td>{{ $unit->cs_number }}</td>
                    <td>{{ $unit->vin_no }}</td>
                    <td>{{ $unit->sales_model }}</td>
                    <td>{{ $unit->model_variant }}</td>
                    <td>{{ $unit->color }}</td>
                    <td>{{ $unit->location }}</td>
                    <td>{{ $unit->pullout_date }}</td>
                    <td>{{ $unit->account_name }}</td>
                    <td>{{ $unit->retail_sale_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>
</div>
<!-- /basic table -->

<!-- /form layouts -->
@stop

@push('scripts')
<script>

     // Setting datatable defaults
        
        /* ------------------------------------------------------------------------------
    *
    *  # Buttons extension for Datatables. HTML5 examples
    *
    *  Demo JS code for datatable_extension_buttons_html5.html page
    *
    * ---------------------------------------------------------------------------- */


    // Setup module
    // ------------------------------

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
            $('.datatable-button-html5-basic').DataTable({
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
         
        },
        created: function () {
           // this.getUnits();
        },
        mounted : function () {
           // Initialize plugin
           
        },
        updated: function(){

        },
        methods :{
       
        }

    });

</script>
@endpush