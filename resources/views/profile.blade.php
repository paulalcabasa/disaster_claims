@extends('layout.template')

@section('page-title','Profile')
@section('content')
<!-- Basic table -->
<div id="app">

    
   <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Profile information</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="#">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>First name</label>
                            <input type="text" v-model="user.first_name"  class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Middle name</label>
                            <input type="text" v-model="user.middle_name" class="form-control">
                        </div>
                         <div class="col-md-4">
                            <label>Last name</label>
                            <input type="text" v-model="user.last_name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="text" v-model="user.email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Dealer</label>
                            <input type="text" :value="dealer.account_name" readonly="readonly" class="form-control">
                        </div>
                    </div>
                </div>
              
                <div class="text-right">
                    <button type="button" @click="updateDetails" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Account settings</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                  
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="#">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Username</label>
                            <input type="text" :value="credentials.user_name" readonly="readonly" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Current password</label>
                            <input type="password" :value="credentials.passcode" readonly="readonly" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>New password</label>
                            <input type="password" v-model="new_password" placeholder="Enter new password" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Repeat password</label>
                            <input type="password" v-model="repeat_password" placeholder="Repeat new password" class="form-control">
                        </div>
                    </div>
                </div>

             
                <div class="text-right">
                    <button type="button" @click="updateCredentials" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    
  
                
</div>

@stop

@push('scripts')
<script>

    var swalInit = swal.mixin({
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-light'
    });

    var vm =  new Vue({
        el : "#app",
        data: {
            user : {!! json_encode($user) !!},
            credentials : {!! json_encode($credentials) !!},
            dealer : {!! json_encode($dealer) !!},
            new_password : '',
            repeat_password : ''
        },
        created: function () {
            
        },
        mounted : function () {
           // Initialize plugin
           
        },
        methods :{
            updateDetails(){
                axios.post('profile/update/details',{
                    user : this.user
                }).then(res => {
                    swalInit({
                        title: 'Success',
                        text: 'You have updated your profile.',
                        type: 'success',
                        allowEscapeKey: false,
                        allowEnterKey: false
                    });
                }).catch(err => {

                });
            },
            updateDetails(){
                axios.post('profile/update/details',{
                    user : this.user
                }).then(res => {
                    swalInit({
                        title: 'Success',
                        text: 'You have updated your profile.',
                        type: 'success',
                        allowEscapeKey: false,
                        allowEnterKey: false
                    });
                }).catch(err => {

                });
            },
            updateCredentials(){
                axios.post('profile/update/credentials',{
                    new_password : this.new_password
                }).then(res => {
                    swalInit({
                        title: 'Success',
                        text: 'You have updated your credentails.',
                        type: 'success',
                        allowEscapeKey: false,
                        allowEnterKey: false
                    });
                    this.credentials.passcode = this.new_password;
                    this.new_password = "";
                    this.repeat_password = "";
                }).catch(err => {

                });
            }
        }

    });

</script>
@endpush