<?php

namespace App\Http\Controllers;

use App\Investment;
use App\Loan;
use App\FundTotal;
use App\Mail\InvestmentNotification;
use App\Trustee;
use Auth;
use App\File;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApplicationNotification;
use App\Mail\ReviewAppNotification;
use Illuminate\Support\Facades\Mail;
use App\InvestorApplication;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\BusinessOwnerApplication;

class InvestorApplicationController extends Controller
{
    public function create()
    {
        return view('investor.application');
    }
    public function store(Request $request)
    {
        $user =Auth::user();
        $investorapplication = new InvestorApplication();
        $fund_total = new FundTotal();
        $investorapplication->user_id = $user->id;
        $investorapplication->inv_first_name=ucfirst($request->input('inv_first_name'));
        $investorapplication->inv_last_name=ucfirst($request->input('inv_last_name'));
        $investorapplication->user_id=$user->id;
        $investorapplication->inv_identification_card_number=$request->input('inv_identification_card_number');
        $investorapplication->inv_date_of_birth=$request->input('inv_date_of_birth');
        $investorapplication->inv_gender=$request->input('inv_gender');
        $investorapplication->inv_street=$request->input('inv_street');
        $investorapplication->inv_city=$request->input('inv_city');
        $investorapplication->inv_state=$request->input('inv_state');
        $investorapplication->inv_zipcode=$request->input('inv_zipcode');
        $investorapplication->inv_country=$request->input('inv_country');
        $investorapplication->inv_phonenumber=$request->input('inv_phonenumber');
        $investorapplication->inv_identity=$request->input('inv_identity');
        $investorapplication->inv_income=$request->input('inv_income');
        $investorapplication->inv_agree_terms=$request->input('inv_agree_terms');
        $investorapplication->inv_net_worth=$request->input('inv_net_worth');
        $investorapplication->inv_estimated_p2p=$request->input('inv_estimated_p2p');
        $investorapplication->inv_risk_tolerance=$request->input('inv_risk_tolerance');
        $investorapplication->inv_stock_market=$request->input('inv_stock_market');
        $investorapplication->inv_bonds_notes=$request->input('inv_bonds_notes');
        $investorapplication->inv_mutual_funds=$request->input('inv_mutual_funds');
        $investorapplication->inv_sme_business=$request->input('inv_sme_business');
        $investorapplication->inv_p2p_lending=$request->input('inv_p2p_lending');
        $investorapplication->save();
        $fund_total->inv_app_id = $investorapplication->id;
        $fund_total->created_by = ucfirst($user->first_name);
        $fund_total->updated_by = ucfirst($user->first_name);
        $fund_total->save();
        if($request->hasFile('inv_income_slip')) {
            $file = new File();
            $file->user_id = $user->id;
            $file->original_filename = $request->file('inv_income_slip')->getClientOriginalName();
            $file->file_path = Storage::putFile('inv_applications', $request->file('inv_income_slip'));
            $file->file_type = 'inv_income_slip';
            $file->save();
        } if($request->hasFile('inv_bank_statements')) {
        $file = new File();
        $file->user_id = $user->id;
        $file->original_filename = $request->file('inv_bank_statements')->getClientOriginalName();
        $file->file_path = Storage::putFile('inv_applications', $request->file('inv_bank_statements'));
        $file->file_type = 'inv_bank_statements';
        $file->save();
        } if($request->hasFile('inv_financial_statements')) {
        $file = new File();
        $file->user_id = $user->id;
        $file->original_filename = $request->file('inv_financial_statements')->getClientOriginalName();
        $file->file_path = Storage::putFile('inv_applications', $request->file('inv_financial_statements'));
        $file->file_type = 'inv_financial_statements';
        $file->save();
        }
        Mail::to($user)->send(new ApplicationNotification($user));
        $request->session()->flash('status','Your application has been successfully submitted');
        return view('investor.index');

    }

    public function update($id)
    {
        InvestorApplication::where('id',$id)->update(array('inv_app_status' =>'Approved'));
        $investor = InvestorApplication::where('id',$id)->first();
        $user = User::where('id',$investor->user_id)->first();
        $role = Role::where('name','investor')->first();
        $user->attachRole($role);
        $message = "Investor Application has been approved for " .$user->first_name. " ".$user->last_name. ".";
        Mail::to($user)->send(new ReviewAppNotification($message));
        $managers = User::where('role_request', 'manager')->get()->toArray();
        if ($managers) {
            Mail::to($managers)->send(new ReviewAppNotification($message));
        }
        return Redirect::back()->with('status','The application has been approved successfully');
    }

    public function show($id)
    {
        $invapp = InvestorApplication::findOrFail($id);
        return view('investor.show',compact('invapp'));
    }

    public function browseloans(){
        $loans = Loan::all();
        $trustees = Trustee::all();
        return view('investor.browseloan', compact('loans', 'trustees'));
    }

    public function investnow($id)
    {
        $loan = Loan::where('id',$id)->first();
        $loan_remaining = number_format($loan->loan_amount - $loan->loan_funded_amount,2,'.','');
        $user =Auth::user();
        $inv = InvestorApplication::where('user_id',$user->id)->first();
        $fundtotal = FundTotal::where('inv_app_id',$inv->id)->first();
        return view('investor.investnow',compact('loan','fundtotal','loan_remaining'));
    }

    public function addinvestment(Request $request)
    {
        $available = $request->input('available_investment');
        $remaining = $request->input('available_loanamount');
        $this->validate($request, [
            'add_investment_amount' => "required|numeric|between:0,$available||between:0,$remaining",
        ]);
        $user =Auth::user();
        $id = $request->input('invested_loan_id');
        $amount = $request->input('add_investment_amount');
        $inv = InvestorApplication::where('user_id',$user->id)->first();
        $investment = Investment::where('investor_application_id',$inv->id)->where('loan_id',$id)->first();
        if($investment){
            Investment::where('investor_application_id',$inv->id)->where('loan_id',$id)
                ->update(array('invested_amount'=> $investment->invested_amount + $amount, 'updated_by'=>$user->first_name));
        } else {
            $investment = new Investment();
            $investment->invested_amount = $amount;
            $investment->investor_application_id = $inv->id;
            $investment->loan_id = $id;
            $investment->created_by  = ucfirst($user->first_name);
            $investment->updated_by  = ucfirst($user->first_name);
            $investment->save();
        }
        $investments = Investment::where('investor_application_id',$inv->id)->first();
        $trustee = new Trustee();
        $trustee->invested_amount = $amount;
        $trustee->investment_id = $investments->id;
        $trustee->invested_status = 'Invested';
        $trustee->loan_id = $id;
        $trustee->created_by = ucfirst($user->first_name);
        $trustee->updated_by = ucfirst($user->first_name);
        $trustee->save();
        $loan = Loan::where('id',$id)->first();
        $boapp = BusinessOwnerApplication::where('id',$loan->business_owner_application_id)->first();
        $boapp = User::where('id', $boapp->user_id)->first();
        Mail::to($user)->send(new InvestmentNotification($user, $boapp, $loan, $amount));
        $managers = User::where('role_request','manager')->get()->toArray();
        if($managers){
            Mail::to($managers)->send(new InvestmentNotification($user, $boapp, $loan, $amount));
        }
        Loan::where('id',$id)->update(array('loan_funded_amount' => $loan->loan_funded_amount + $request->input('add_investment_amount')));
        $updatedloan = Loan::where('id',$id)->first();
        $funded = $updatedloan->loan_funded_amount/$updatedloan->loan_amount;
        $fundedpercentage = round((float)$funded * 100 ,2);
        Loan::where('id',$id)->update(array('loan_funded_percent' => $fundedpercentage));
        $fundtotal = FundTotal::where('inv_app_id',$inv->id)->first();
        FundTotal::where('id',$fundtotal->id)->update(array('funds_total' => $fundtotal->funds_total - $amount, 'updated_by' => $user->first_name));
        $loans = Loan::all();
        $trustees = Trustee::all();
        $request->session()->flash('status', 'Your investment has been submitted successfully');
        return view('investor.browseloan', compact('loans', 'trustees'));
    }
}
