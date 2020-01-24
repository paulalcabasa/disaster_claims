@extends('layout.template')

@section('page-title','Claim Entry')
@section('content')

<!-- Form layouts -->
<div class="row">
    <div class="col-md-6">

        <!-- Horizontal form -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Horizontal form</h5>
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
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Text input</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Password</label>
                        <div class="col-lg-9">
                            <input type="password" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Select</label>
                        <div class="col-lg-9">
                            <select name="select" class="form-control">
                                <option value="opt1">Basic select</option>
                                <option value="opt2">Option 2</option>
                                <option value="opt3">Option 3</option>
                                <option value="opt4">Option 4</option>
                                <option value="opt5">Option 5</option>
                                <option value="opt6">Option 6</option>
                                <option value="opt7">Option 7</option>
                                <option value="opt8">Option 8</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Textarea</label>
                        <div class="col-lg-9">
                            <textarea rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /horizotal form -->

    </div>

    <div class="col-md-6">

        <!-- Vertical form -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Vertical form</h5>
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
                        <label>Text input</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Select</label>
                        <select name="select" class="form-control">
                            <option value="opt1">Basic select</option>
                            <option value="opt2">Option 2</option>
                            <option value="opt3">Option 3</option>
                            <option value="opt4">Option 4</option>
                            <option value="opt5">Option 5</option>
                            <option value="opt6">Option 6</option>
                            <option value="opt7">Option 7</option>
                            <option value="opt8">Option 8</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Textarea</label>
                        <textarea rows="4" cols="4" class="form-control" placeholder="Default textarea"></textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /vertical form -->

    </div>
</div>
<!-- /form layouts -->
@stop