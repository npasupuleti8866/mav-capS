@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row">
            <h2 class="text-center">Review Business Owner Applications</h2>
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
                    @foreach($boapps as $boapp)
                        @if($boapp->bo_app_status == '')
                    <tr>
                        <th scope="row">{{$boapp->bo_first_name}} {{$boapp->bo_last_name}}</th>
                        <td><a href="{{url('bo_application',$boapp->id)}}" class="btn btn-info btn-sm" id="review_bopending_viewdetails">View Details</a>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bo_download" id="review_bopending_download">Download</button>
                            <div class="modal fade" id="bo_download" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Download Documents</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Please click on the below links to download a specific document.</p>
                                            <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_upload_IC'])}}">Self Identification</a><br>
                                            <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_business_license'])}}">Business License</a><br>
                                            <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_entity_type'])}}">Business Entity Type</a><br>
                                            <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_CTOS'])}}">CTOS Documents</a><br>
                                            <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_audited_statements'])}}">Audited Financial Statements</a><br>
                                            <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_operating_statements'])}}">Operating Bank Statements</a><br>
                                            <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_tax_returns'])}}">Tax Return Forms</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-dismiss="modal" id="bo_download_ok_confirm">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           </td>
                        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bo_approvebutton" id="boappbutton_approve">Approve</button>
                            <div class="modal fade" id="bo_approvebutton" role="dialog">
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
                                            {!!Form::model($boapp,array('route'=>['bo_application.update',$boapp->id],'method'=>'PATCH'))!!}
                                            {!! Form::submit('Yes', ['class' => 'btn btn-success btn-sm','id' =>'accept'])!!}
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="review_boapp_no">No</button>
                                            {!!Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#bo_rejectbutton" id="reviewboapp_reject">Reject</button>
                            <div class="modal fade" id="bo_rejectbutton" role="dialog">
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
                                            <form role="form" method="POST" action="{{ url('bo_app_reject') }}">{{ csrf_field() }}
                                                <input type="hidden" name="bo_app_id" value="{{ $boapp->id }}">
                                                <button type="submit" id="reject" class="btn btn-success btn-sm">Yes</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="review_boapp_no">No</button>
                                            </form>
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
                    @foreach($boapps as $boapp)
                        @if($boapp->bo_app_status != '')
                            <tr>
                                <th scope="row">{{$boapp->bo_first_name}} {{$boapp->bo_last_name}}</th>
                                <td><a href="{{url('bo_application',$boapp->id)}}" class="btn btn-info btn-sm" id="review_bopending_viewdetails">View Details</a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bo_download" id="review_bopending_download">Download</button>
                                    <div class="modal fade" id="bo_download" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Download Documents</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Please click on the below links to download a specific document.</p>
                                                    <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_upload_IC'])}}">Self Identification</a><br>
                                                    <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_business_license'])}}">Business License</a><br>
                                                    <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_entity_type'])}}">Business Entity Type</a><br>
                                                    <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_CTOS'])}}">CTOS Documents</a><br>
                                                    <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_audited_statements'])}}">Audited Financial Statements</a><br>
                                                    <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_operating_statements'])}}">Operating Bank Statements</a><br>
                                                    <a href="{{url('downloadbo',['id' => $boapp->id, 'filetype' => 'bo_tax_returns'])}}">Tax Return Forms</a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success" data-dismiss="modal" id="bo_download_ok_confirm">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$boapp->bo_app_status == '' ? 'Pending' : $boapp->bo_app_status}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection