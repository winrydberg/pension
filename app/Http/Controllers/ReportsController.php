<?php

namespace App\Http\Controllers;

use App\Exports\CompanyReportExport;
use App\Exports\SchemeReportExport;
use App\Models\Claim;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function reportsByCompany(Request $request){
        
        $startdate = $request->query('startdate', null);
        $enddate = $request->query('enddate', null);
        $companyid = $request->query('company', null);
        $companies = Company::all();
        //JUST RETURN VIEW FOR SEARCHING
        if($startdate == null || $enddate ==null || $companyid == null){
            return view('reports.companyreports', compact('companies'));
        }

        $selcompany = Company::where('id', $companyid)->first();

        $claims = Claim::select(
            DB::raw('sum(claim_amount) as sums'), 
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
            )->where('created_at','>=', $startdate)
            ->where('created_at', '<=',$enddate)
            ->where('claim_state_id', 6)
            ->where('company_id', $companyid)
            ->groupBy('months','scheme_id')
            ->get();

        $total_amount = 0;
        foreach($claims as $claim){
            $total_amount += (int)$claim->sums;
        }
        return view('reports.companyreports', compact('companies', 'claims', 'total_amount', 'selcompany'));
    }


    public function reportsByScheme(Request $request){
        $startdate = $request->query('startdate', null);
        $enddate = $request->query('enddate', null);
        $schemeid = $request->query('scheme', null);

        $schemes = Scheme::all();
        
        //JUST RETURN VIEW FOR SEARCHING
        if($startdate == null || $enddate ==null || $schemeid == null){
            return view('reports.schemereports', compact('schemes'));
        }

        $selscheme = Scheme::find($schemeid);
        //GENERATE REPORT BY SCHEME FOR SPECIFIED DATES
        $claims = Claim::select(
            DB::raw('sum(claim_amount) as sums'), 
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
            )->where('created_at','>=', $startdate)
            ->where('created_at', '<=',$enddate)
            ->where('claim_state_id', 6)
            ->where('scheme_id', $schemeid)
            ->groupBy('months')
            ->get();
        $total_amount = 0;
        foreach($claims as $claim){
            $total_amount += (int)$claim->sums;
        }
        return view('reports.schemereports', compact('schemes', 'claims', 'total_amount', 'selscheme'));
    }


    public function excelExports(Request $request){
        $startdate = $request->query('startdate', null);
        $enddate = $request->query('enddate', null);
        $companyid = $request->query('company', null);
        $schemeid = $request->query('scheme', null);

        $data = null;
        if($companyid){
            $claims = Claim::where('created_at','>=', $startdate)
                        ->where('created_at', '<=',$enddate)
                        ->where('company_id', $companyid)
                        ->with('scheme', 'customers')
                        ->get();
            $data = [];

            $sum = 0.0;
        
            foreach($claims as $claim){
                $createdmonth = date('F Y', strtotime($claim->created_at)); //date_format($claim->created_at,"M, Y"); //date("%m %Y", strtotime($claim->created_at));
                $createdat = date('d-m-Y', strtotime($claim->created_at));
                $sum += (float)$claim->claim_amount;
                if(array_key_exists($createdmonth, $data)){
                    if(array_key_exists($createdat, $data[$createdmonth]['breakdown'])){
                        $data[$createdmonth]['monthtotal'] += (float)$claim->claim_amount;
                        if($claim->customers->count() > 0){
                            array_push($data[$createdmonth]['employees'], $claim->customers->toArray());
                        }
                        $data[$createdmonth]['breakdown'][$createdat] += (float)$claim->claim_amount;
                    }else{
                        $data[$createdmonth]['monthtotal'] += (float)$claim->claim_amount;
                        if($claim->customers->count() > 0){
                            array_push($data[$createdmonth]['employees'], $claim->customers->toArray());
                        }
                        $data[$createdmonth]['breakdown'][$createdat] = (float)$claim->claim_amount;
                    }
                }else{
                    $data[$createdmonth] = [
                        'monthtotal' => (float)$claim->claim_amount,
                        'employees' => [$claim->customers->toArray()], //->count() > 0 ? [$claim->customers]: [],
                        'breakdown' =>  [$createdat => (float)$claim->claim_amount]
                    ];
                }
            }
            // dd($data);s
            $company = Company::find($companyid);
            $callingdata = [
                'amount' => $sum,
                'data' => $data
            ];
            $export = new CompanyReportExport($callingdata, $company);
            $fileName = strtoupper($company->name).'_'.$startdate.'_TO_'.$enddate.'REPORTS';
            return Excel::download($export, $fileName.'.xlsx');
        }
        
        else if($schemeid){
            $claims = Claim::where('created_at','>=', $startdate)
                        ->where('created_at', '<=',$enddate)
                        ->where('scheme_id', $schemeid)
                        ->with('customers')
                        ->get();
            $data = [];

            $sum = 0.0;
            
            foreach($claims as $claim){
                $createdmonth = date('F Y', strtotime($claim->created_at)); //date_format($claim->created_at,"M, Y"); //date("%m %Y", strtotime($claim->created_at));
                $createdat = date('d-m-Y', strtotime($claim->created_at));
                $sum += (float)$claim->claim_amount;
                if(array_key_exists($createdmonth, $data)){
                    if(array_key_exists($createdat, $data[$createdmonth]['breakdown'])){
                        $data[$createdmonth]['monthtotal'] += (float)$claim->claim_amount;
                        if($claim->customers->count() > 0){
                        array_push($data[$createdmonth]['employees'], $claim->customers->toArray());
                        }
                        $data[$createdmonth]['breakdown'][$createdat] += (float)$claim->claim_amount;
                    }else{
                        $data[$createdmonth]['monthtotal'] += (float)$claim->claim_amount;
                        if($claim->customers->count() > 0){
                        array_push($data[$createdmonth]['employees'], $claim->customers->toArray());
                        }
                        $data[$createdmonth]['breakdown'][$createdat] = (float)$claim->claim_amount;
                    }
                }else{
                    $data[$createdmonth] = [
                        'monthtotal' => (float)$claim->claim_amount,
                        'employees' => [$claim->customers->toArray()], //->count() > 0 ? [$claim->customers]: [],
                        'breakdown' =>  [$createdat => (float)$claim->claim_amount]
                    ];
                }
            }
            $scheme = Scheme::find($schemeid);
            $callingdata = [
                'amount' => $sum,
                'data' => $data
            ];
            $export = new SchemeReportExport($callingdata, $scheme);
            $fileName = strtoupper($scheme->name.'_'.$scheme->tiertype).'_'.$startdate.'_TO_'.$enddate.'REPORTS';
            return Excel::download($export, $fileName.'.xlsx');
        }else{

        }
        if($data == null){
            return redirect()->back()->with('error', 'Claims Not Found. Please search again');
        }
    }




    public function reportsBreakdown(Request $request){
        $month = $request->query('month', null);
        $company = $request->query('company', null);
        $scheme = $request->query('scheme', null);

        if($company ==null | $month == null){
            return back()->with('error', 'Ooops, Unable to get breakdown. Please try again');
        }


        $quit = true;
        if($company != null){
            $claimsIds = Claim::where('company_id', $company)->whereMonth('created_at', date_parse($month)['month'])->whereYear('created_at', date_parse($month)['year'])->pluck('id');
            // Log::info($claimsIds);
            $employees = Customer::whereIn('claim_id', $claimsIds)->get();
            
            $company = Company::find($company);

            $title = $company?->name." Reports For ". $month. ' Breakdown';
            
            return view('reports.breakdown', compact('employees', 'company', 'title'));
        }else if($scheme != null){
           
            $scheme = Scheme::find($scheme);
            $claimsIds = Claim::where('scheme_id', $scheme)->whereMonth('created_at', date_parse($month)['month'])->whereYear('created_at', date_parse($month)['year'])->pluck('id');
            //Log::info($claimsIds);
            $employees = Customer::whereIn('claim_id', $claimsIds)->get();

            $title = $scheme?->name." Reports For ". $month. ' Breakdown';
            
            return view('reports.breakdown', compact('employees', 'scheme', 'title'));
        }else{
            return back()->with('error', 'Ooops, Unable to get breakdown. Please try again'); 
        }
        
    }



}
