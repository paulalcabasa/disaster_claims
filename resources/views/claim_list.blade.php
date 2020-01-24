@extends('layout.template')

@section('page-title','Claim Entry')
@section('content')
<!-- Basic table -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Basic table</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        Seed project includes the most basic components that can help you in development process - basic grid example, card, table and form layouts with standard components. Nothing extra. Easily turn on and off styles of different components in <code>_config.scss</code> file so that your CSS is always as clean as possible. Bootstrap components are always enabled though.
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Eugene</td>
                    <td>Kopyov</td>
                    <td>@Kopyov</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Victoria</td>
                    <td>Baker</td>
                    <td>@Vicky</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>James</td>
                    <td>Alexander</td>
                    <td>@Alex</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Franklin</td>
                    <td>Morrison</td>
                    <td>@Frank</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- /basic table -->

<!-- /form layouts -->
@stop