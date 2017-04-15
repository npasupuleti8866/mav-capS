@extends('layouts.app')
@section('content')
    <div class="container" >
        <div class="row">
            <h1 class="text-center">Repayment</h1>
            <hr>
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-hover table-responsive" id="repayment_table">
                    <thead>
                    <tr>
                        <th>Loan Title</th>
                        <th>Loan Amount</th>
                        <th>Loan Duration</th>
                        <th>Total Paid Amount</th>
                        <th>Remaining Amount</th>
                        <th>Interest Rate %</th>
                        <th>Details</th>
                        <th>Date/Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{$amortizations}}
                    @foreach($loans as $loan)
                        @if($loan->loan_status == 'Loan Disbursed')
                            <tr>
                                <td>{{$loan->loan_title}}</td>
                                <td>MYR {{$loan->loan_amount}}</td>
                                <td>{{$loan->loan_duration}}</td>
                                <td> Sample</td>
                                <td> Sample</td>
                                <td>{{$loan->loan_interest_rate}}%</td>
                                <td>
                                    <!--View Details Button-->
                                    <a href="{{url('loan_repayment_details')}}" class="btn btn-info btn-sm" id="repayment_view_details">View Details</a>
                                </td>
                                <td>{{$loan->updated_at}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div align="right">
            <a href="{{ url()->previous() }}" class="btn btn-info" id="repayment_back">Back</a>
        </div>
    </div>
@endsection