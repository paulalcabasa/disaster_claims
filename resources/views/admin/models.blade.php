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
                    <th>Model ID</th>
                    <th>Model Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in list">
                    <td>@{{ row.model_id }}</td>
                    <td>@{{ row.model_name }}</td>
                    <td>
                        <a href="#" @click="edit(row)">
                            <i class="icon-pen6"></i>
                        </a>
					</td>
                </tr>
            </tbody>
        </table> 
    </div>

    <div id="parts_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@{{ model.model_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Part Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr v-for="(row,index) in parts" v-show="row.delete_flag == 'N'">
                              
                                <td><input type="text" class="form-control" placeholder="Kindly indicate the part name..." v-model="row.description" /></td>
                                <td>
                                    <a href="#" @click="deletePart(row,index)">
                                        <i class="icon-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-primary text-left" @click="addPart">Add</button>
                    <button type="button" class="btn bg-success" @click="save">Save changes</button>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /basic modal -->

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
            list : [],
            model : {},
            parts : []
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
           edit(row){
               this.model = row;
           
                axios.get('parts/get/' + row.model_id)
                .then( (response) => {
                    this.parts = response.data;
            
                }).catch( (error) => {
                    console.log(error);
                });

               $("#parts_modal").modal('show');
           },
           addPart(){
               this.parts.push({
                   part_id : '',
                   description : '',
                   delete_flag : 'N'
               });
           },
           deletePart(row,index){
                if(row.part_id == ""){
                    this.parts.splice(index,1);
                }
                else {
                    this.parts[index].delete_flag = 'Y';
                }
           },
           save(){
               axios.post('parts/submit', {
                   model : this.model,
                   parts : this.parts
               }).then( res => {
                   swalInit({
                        title: 'Parts Update',
                        text: res.data.message,
                        type: 'success',
                        allowEscapeKey: false,
                        allowEnterKey: false
                    });
               }).catch(err => {
                   console.log(err);
               });
           }
        }

    });

</script>
@endpush