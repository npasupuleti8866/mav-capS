@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row">
            <h2 class="text-center">Review Investor Applications</h2>
            <hr>
            <div class="col-md-10 col-md-offset-1">
                @if (session('status'))
                    <div class="alert alert-success text-center">
                        {{ session('status') }}
                    </div>
                @endif
                <h3 style="color: darkblue">Pending Applications</h3>
                <table class="table table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invapps as $invapp)
                        @if($invapp->inv_app_status == '')
                            <tr>
                                <th scope="row">{{$invapp->inv_first_name}} {{$invapp->inv_last_name}}</th>
                                <td><a href="{{url('inv_application',$invapp->id)}}" class="btn btn-info btn-sm" id="invapp_pending_viewdetails">View Details</a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#inv_download" id="invapp_pending_download">Download</button>
                                    <div class="modal fade" id="inv_download" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Download Documents</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Please click on the below links to download a specific document.</p>
                                                    <a href="{{url('downloadinv',['id' => $invapp->id, 'filetype' => 'inv_income_slip'])}}">Income Slip</a><br>
                                                    <a href="{{url('downloadinv',['id' => $invapp->id, 'filetype' => 'inv_bank_statements'])}}">Bank Statements</a><br>
                                                    <a href="{{url('downloadinv',['id' => $invapp->id, 'filetype' => 'inv_financial_statements'])}}">Audited Financial Statements</a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success" data-dismiss="modal" id="inv_download_ok_confirm">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#inv_approvebutton" id="invapp_approve">Approve</button>
                                    <div class="modal fade" id="inv_approvebutton" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Confirmation</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to accept this application?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    {!!Form::model($invapp,array('route'=>['inv_application.update',$invapp->id],'method'=>'PATCH'))!!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-success btn-sm','id' =>'accept'])!!}
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="review_invapp_no">No</button>
                                                    {!!Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#inv_rejectbutton" id="invapp_reject">Reject</button>
                                    <div class="modal fade" id="inv_rejectbutton" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Confirmation</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to reject this application?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    {!!Form::model($invapp,array('route'=>['loan_application.update',$invapp->id],'method'=>'PATCH'))!!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-success btn-sm','id' =>'reject'])!!}
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="review_invapp_no1">No</button>
                                                    {!!Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <h3 style="color: darkblue">Accepted/Rejected Applications</h3>
                <table class="table table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invapps as $invapp)
                        @if($invapp->inv_app_status != '')
                            <tr>
                                <th scope="row">{{$invapp->inv_first_name}} {{$invapp->inv_last_name}}</th>
                                <td><a href="{{url('inv_application',$invapp->id)}}" class="btn btn-info btn-sm" id="invapp_pending_viewdetails">View Details</a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#inv_download" id="invapp_pending_download">Download</button>
                                    <div class="modal fade" id="inv_download" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Download Documents</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Please click on the below links to download a specific document.</p>
                                                    <a href="{{url('downloadinv',['id' => $invapp->id, 'filetype' => 'inv_income_slip'])}}">Income Slip</a><br>
                                                    <a href="{{url('downloadinv',['id' => $invapp->id, 'filetype' => 'inv_bank_statements'])}}">Bank Statements</a><br>
                                                    <a href="{{url('downloadinv',['id' => $invapp->id, 'filetype' => 'inv_financial_statements'])}}">Audited Financial Statements</a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success" data-dismiss="modal" id="inv_download_ok_confirm">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$invapp->inv_app_status == '' ? 'Pending' : $invapp->inv_app_status}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection