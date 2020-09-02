<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\InformationMail;

class UserController extends Controller
{
     //======================================================================
    // COnstrutor
    //======================================================================
    public function __construct()
    {
        $this->middleware(['auth:user','verified']);
    }

    public function Dashboard()
    {
        return view("user.dashboard");
    }
    

    
    
    
    
    
    
    //=====================================================
    //      My Purchases Functions
    //=====================================================
    
    public function myPurchases()
    {
        $accounts = 
        
        
        DB::table('bought_accounts')
            ->join('accounts', 'accounts.id', '=', 'bought_accounts.account_id')
            ->where('user_id', Auth::user()->id)
            ->get();

        $fullz = DB::table('bought_fullz')
        ->join('fullz', 'fullz.id', '=', 'bought_fullz.fullz_id')
        ->where('user_id', Auth::user()->id)
        ->get();

        $banks = DB::table('bought_banks')
        ->join('banks', 'banks.id', '=', 'bought_banks.banks_id')
        ->where('user_id', Auth::user()->id)
        ->get();
        
        return view('user.mypurchases')->with(['accounts' => $accounts, 'fullz' => $fullz, 'banks' => $banks]);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //=====================================================
    //      FULLZ Functions
    //=====================================================

    public function fullzMy3()
    {
        $accounts = DB::table('fullz')->where(['record_type'=> 'My3'])->paginate(15);

        return view('user.fullz')->with(['accounts' => $accounts]);
    }

    
    public function fullzO2()
    {
        $accounts = DB::table('fullz')->where(['record_type'=> 'O2'])->paginate(15);

        return view('user.fullz')->with(['accounts' => $accounts]);
    }
    
    
    public function fullzEE()
    {
        $accounts = DB::table('fullz')->where(['record_type'=> 'EE'])->paginate(15);

        return view('user.fullz')->with(['accounts' => $accounts]);
    }
    
    
    public function fullzHMRC()
    {
        $accounts = DB::table('fullz')->where(['record_type'=> 'HMRC'])->paginate(15);

        return view('user.fullz')->with(['accounts' => $accounts]);
    }


    public function buyFullz(Request $request)
    {
        #buy and update to table
        if(is_numeric($request->input('fullz_id')))
        {
            $accounts = DB::table('fullz')->where([
                'id' => $request->input('fullz_id')
            ])->get();

            $balance = DB::table('users')->select('balance')->where([
                'id' =>  Auth::user()->id,
                'email' => Auth::user()->email,
            ])->get();

            if($balance[0]->balance > $accounts[0]->price)
            {
                $count = DB::table('users')->where([
                    'id' =>  Auth::user()->id,
                    'email' => Auth::user()->email,
                    ])->update([
                    'balance' => $balance[0]->balance - $accounts[0]->price
                ]);
                
                if($count != null)
                {
                    $check = DB::table('bought_fullz')->insert([

                        'user_id' => Auth::user()->id,
                        'fullz_id' => $request->input('fullz_id'),
                        'created_at' => NOW()
                    ]);
            
                    if($check == true)
                    {
                        return back()->with(["success" => "Purchased Successfully"]);
                    }

                    return back()->withErrors(["WrongInput" => "Something Went Wrong."]);
                }
            }
        }


        #buy and update to table
        return back()->withErrors(["WrongInput" => "Account Balance Not Sufficent"]);
    }

    public function FullzBinSearch(Request $request)
    {
        if(is_numeric($request->input('binSearch')))
        {
            $accounts = DB::table('fullz')
                    ->where('record_type', $request->route('fullzType'))
                    ->where('card_bin', $request->input('binSearch'))
                    ->paginate(1500);
            return view('user.fullz')->with(['accounts' => $accounts]);
        }
        return back()->withErrors(["WrongInput" => "Wrong Bin Type"]);
    }


    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //===============================================
    //  Support Section
    //===============================================
    public function NewTicket()
    {
        return view('user.newTicket');
    }

    public function NewTicketSubmit(Request $request)
    {
        Mail::to("admin@marioLugi.com")->send(new InformationMail(json_encode((array(['subject'=>$request->input('subject'),'email'=>Auth::user()->email,'content'=>$request->input('content')])),true)));
        return back()->with(["success" => "Ticket Posted Successfully"]);

        // Original 
        if($request->input('g-recaptcha-response') === null)
        {
            return back()->withErrors(["WrongInput" => "Please check the the captcha form."]);
        }
        else
        {
            $secretKey = "6Ldp_8QZAAAAAJ_4yhcSrqipDaXppOHs3Ft_9J1v";
            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($request->input('g-recaptcha-response'));
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);
            // should return JSON with success as true
            if($responseKeys["success"]) {
        
                Mail::to("admin@marioLugi.com")->send(new InformationMail(json_encode((array(['subject'=>$request->input('subject'),'email'=>Auth::user()->email,'content'=>$request->input('content')])),true)));

                return back()->with(["success" => "Ticket Posted Successfully"]);
            } else {
                return back()->withErrors(["WrongInput" => "Sorry, Spammer"]);
            }
        }
    }



















    //=====================================================
    //      ACCOUNTS Functions
    //=====================================================

    public function AccountsPaypal()
    {
        $accounts = DB::table('accounts')->where(['record_type'=> 'paypal'])->paginate(15);
        return view('user.accounts')->with(['accounts' => $accounts]);
    }

    public function buyAccounts(Request $request)
    {
        if(is_numeric($request->input('account_id')))
        {
            $accounts = DB::table('accounts')->where([
                'id' => $request->input('account_id'),
                'record_type'=> 'paypal'
            ])->get();

            $balance = DB::table('users')->select('balance')->where([
                'id' =>  Auth::user()->id,
                'email' => Auth::user()->email,
            ])->get();

            if($balance[0]->balance > $accounts[0]->price)
            {
                $count = DB::table('users')->where([
                    'id' =>  Auth::user()->id,
                    'email' => Auth::user()->email,
                    ])->update([
                    'balance' => $balance[0]->balance - $accounts[0]->price
                ]);
                
                if($count != null)
                {
                    $check = DB::table('bought_accounts')->insert([

                        'user_id' => Auth::user()->id,
                        'account_id' => $request->input('account_id'),
                        'created_at' => NOW()
                    ]);
            
                    if($check == true)
                    {
                        return back()->with(["success" => "Purchased Successfully"]);
                    }

                    return back()->withErrors(["WrongInput" => "Something Went Wrong."]);
                }
            }
        }


        #buy and update to table
        return back()->withErrors(["WrongInput" => "Account Balance Not Sufficent"]);
    }

















    //=====================================================
    //      BANKS Functions
    //=====================================================

    public function Banks()
    {
        $accounts = DB::table('banks')->paginate(15);
        
        return view('user.Banks')->with(['accounts' => $accounts]);
    }

    public function BanksBinSearch(Request $request)
    {
        if(is_numeric($request->input('binSearch')))
        {
            $accounts = DB::table('banks')
            ->where('card_no', 'like', $request->input('binSearch').'%')
            ->paginate(1000);

            return view('user.Banks')->with(['accounts' => $accounts]);
        }
        return back()->withErrors(["WrongInput" => "Wrong Bin Type"]);
    }

    public function buyBanks(Request $request)
    {
        #buy and update to table
        if(is_numeric($request->input('banks_id')))
        {
            $accounts = DB::table('banks')->where([
                'id' => $request->input('banks_id')
            ])->get();

            $balance = DB::table('users')->select('balance')->where([
                'id' =>  Auth::user()->id,
                'email' => Auth::user()->email,
            ])->get();

            if($balance[0]->balance > $accounts[0]->price)
            {
                $count = DB::table('users')->where([
                    'id' =>  Auth::user()->id,
                    'email' => Auth::user()->email,
                    ])->update([
                    'balance' => $balance[0]->balance - $accounts[0]->price
                ]);
                
                if($count != null)
                {
                    $check = DB::table('bought_banks')->insert([

                        'user_id' => Auth::user()->id,
                        'banks_id' => $request->input('banks_id'),
                        'created_at' => NOW()
                    ]);
            
                    if($check == true)
                    {
                        return back()->with(["success" => "Purchased Successfully"]);
                    }

                    return back()->withErrors(["WrongInput" => "Something Went Wrong."]);
                }
            }
        }


        #buy and update to table
        return back()->withErrors(["WrongInput" => "Account Balance Not Sufficent"]);
    }




    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //===============================
    //  My Account Management
    //===============================

    public function MyAccount()
    {
        return view('user.MyAccount');
    }

    public function ManageMyAccount(Request $request)
    {
        if($request->has('profileForm'))
        {
            $count = DB::table('users')->where([

                'id' =>  Auth::user()->id,
                'email' => Auth::user()->email,
                
                ])->update([
    
                'telegram' => $request->input('telegram'),
                'updated_at' => Carbon::now()
    
            ]);
            
            if($count != null)
            {
                return back()->with(["success" => "Data Updated Successfully"]);
            }
        }
        else if($request->has('passwordForm'))
        {
            if(Hash::check($request->input('curPass'), Auth::user()->password))
            {
                $count = DB::table('users')->where([

                    'id' =>  Auth::user()->id,
                    'email' => Auth::user()->email,
                    
                    ])->update([
        
                    'password' => Hash::make($request->input('newPass')),
                    'updated_at' => Carbon::now()
        
                ]);
                
                if($count != null)
                {
                    Auth::logout();
                    return redirect('/')->with(["success" => "Password Updated Successfully"]);
                }
            }

            return back()->withErrors(["WrongInput" => "Current password wrong."]);
            
        }
        return back()->withErrors(["WrongInput" => "Something went Wrong"]);
    }


    public function Rules()
    {
        return view('user.Rules');
    }
    public function Support()
    {
        return view('user.Support');
    }


    public function ViewAddFunds(Request $request)
    {
        if($request->has('fundsButton'))
        {
            if(is_numeric($request->input('amount')))
            {
                $amount =  $request->input('amount') + 0;

                if($amount >= 1)
                {
                    return view('user.addfunds')->with(["amount" => $amount, "userId" => Auth::user()->id]);
                }
                else
                {
                    return back()->withErrors(["WrongInput" => "Minimum is 1 USD"]);
                }
            }
            return back()->withErrors(["WrongInput" => "Incorrect Amount Entered"]);
        }
        return view('user.addfunds');
    }



























































    public function ShowForms(Request $request)
    {
        //get the active test where(isActive, 1);
        $DataBase_forms = DB::table('forms')->where([

            'admin_id' => Auth::user()->admin_id,
            'company_id' => Auth::user()->company_id,
            'isActive' => 1

        ])->get();
        
        $forms = array();

        if(!$DataBase_forms->isEmpty()) //if there are any forms
        {
            foreach ($DataBase_forms as $f) {
                $allowed_users = json_decode($f->allowed, true);
                if($allowed_users != null)
                {
                    foreach ($allowed_users as $key => $value)
                    {
                        if(Auth::user()->id == intval($value))
                        {
                            array_push($forms, $f);
                        }
                    }
                }
            }
            return view('user.forms')->with(['form' => $forms]);
        }
        else
        {  
            return redirect()->intended('/user')->withErrors(["WrongInput" => "No Form"]);
        }
        return redirect('/user')->withErrors(["WrongInput" => "Something went Wrong"]);
    }

    public function ShowPublishedForms(Request $request)
    {
       //get the active test where(isActive, 1);
       $DataBase_forms = DB::table('forms')->where([

        'admin_id' => Auth::user()->admin_id,
        'company_id' => Auth::user()->company_id,
        'isActive' => 1

        ])->get();
        
        $forms = array();

        if(!$DataBase_forms->isEmpty()) //if there are any forms
        {
            foreach ($DataBase_forms as $f) {
                $allowed_users = json_decode($f->allowed, true);
                if($allowed_users != null)
                {
                    foreach ($allowed_users as $key => $value)
                    {
                        if(Auth::user()->id == intval($value))
                        {
                            array_push($forms, $f->id);
                        }
                    }
                }
            }
        }
        else
        {  
            return redirect()->intended('/user')->withErrors(["WrongInput" => "No Forms"]);
        }
        
        $sent_form = DB::table('sent_forms')->whereIn('form_id', $forms)->get();


        if(!$sent_form->isEmpty())
        {
            return view('user.sentforms')->with(['form' => $sent_form]);
        }

        return redirect('/user')->withErrors(["WrongInput" => "No Published Form"]);
    }

    public function ShowSavedForms(Request $request)
    {
        //get the active test where(isActive, 1);
        $DataBase_forms = DB::table('forms')->where([

            'admin_id' => Auth::user()->admin_id,
            'company_id' => Auth::user()->company_id,
            'isActive' => 1

        ])->get();
        
        $forms = array();

        if(!$DataBase_forms->isEmpty()) //if there are any forms
        {
            foreach ($DataBase_forms as $f) {
                $allowed_users = json_decode($f->allowed, true);
                if($allowed_users != null)
                {
                    foreach ($allowed_users as $key => $value)
                    {
                        if(Auth::user()->id == intval($value))
                        {
                            array_push($forms, $f->id);
                        }
                    }
                }
            }
        }
        else
        {  
            return redirect()->intended('/user')->withErrors(["WrongInput" => "No Forms"]);
        }
        
        $saved_form = DB::table('saved_form')->whereIn('form_id', $forms)->get();

        if(!$saved_form->isEmpty())
        {
            return view('user.savedforms')->with(['form' => $saved_form]);
        }

        return redirect('/user')->withErrors(["WrongInput" => "No Saved Form"]);
    }



    //USE FORM (DISPLAY FORM)
    public function UseForm(Request $request)
    {
        //get the active test where(isActive, 1);
        $DataBase_forms = DB::table('forms')->where([

            'id' => $request->route('formId'),
            'admin_id' => Auth::user()->admin_id,
            'company_id' => Auth::user()->company_id,
            'isActive' => 1
            

        ])->get();


        $saved_data = DB::table('saved_form')->where([

            'form_id' => $request->route('formId'),
            'admin_id' => Auth::user()->admin_id,
            'company_id' => Auth::user()->company_id,
            'isActive' => 1
        ])->get();

            
        //dd($DataBase_forms[0]);

        if(!$DataBase_forms->isEmpty())
        {
            return view('user.useform')->with(['form' => $DataBase_forms[0], 'savedData' => $saved_data]);
        }
        return redirect('/user')->withErrors(["WrongInput" => "Something went Wrong"]);
    }

    //SAVE FORM
    public function SaveForm(Request $request)
    {
        $formId = $request->route('formId');
        $data = $request->input('data');
        $form_name = $request->input('form_name');

        $check = DB::table('saved_form')->updateOrInsert(
            [
                'form_id' => $formId,
                'admin_id' => Auth::user()->admin_id,
                'company_id' => Auth::user()->company_id,
            ],
            [
                'form_name' => $form_name,
                'form_id' => $formId,
                'admin_id' => Auth::user()->admin_id,
                'company_id' => Auth::user()->company_id,
                'data' => $data,
                'isActive' => 1,
                'created_at' => Carbon::now() ,
            ]
        );

        if($check == true)
        {
            return "success";
        }
        else
        {
            return "Error While Saving";
        }
    }


    public function SendForm(Request $request)
    {
        $imgList = explode(',', $request->input('imagesData'));
        
        $uploads = array();
        foreach($_FILES as $key0=>$FILES) {
            foreach($FILES as $key=>$value) {
                foreach($value as $key2=>$value2) {
                    $uploads[$key0][$key2][$key] = $value2;
                }
            }
        }
        //dd($uploads);

        if($uploads != null)
        {
            $targetDir = "content/";

            foreach($uploads["files"] as $key=>$value)
            {
                if($uploads["files"][$key]["size"] < 50000000)
                {
                    if($uploads["files"][$key]['error'] == 0)
                    {
                        if($uploads["files"][$key]["tmp_name"] != "")
                        {
                            $filename = $uploads["files"][$key]['name'];
                            $targetFilePath = $targetDir.NOW().time().$filename;
                            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                            
                        }else {
                            return "Temporary File not Found in Header";
                        }
                    }else {
                        return "Error";
                    }
                }else {
                    return "Size Greater than 50MB";
                }
            }


            foreach($uploads["files"] as $key=>$value)
            {
                if($uploads["files"][$key]['error'] == 0)
                {
                    if($uploads["files"][$key]["tmp_name"] != "")
                    {
                        if($uploads["files"][$key]["size"] > 0)
                        {
                            $filename = $uploads["files"][$key]['name'];
                            //$targetFilePath = $targetDir.time().time().$filename;
                            $targetFilePath = $targetDir.$imgList[$key];
                            //dd($targetFilePath);
                            if(move_uploaded_file($uploads["files"][$key]['tmp_name'], $targetFilePath))
                            {

                            }
                            else
                            {
                                return "Insertion ERROR";
                            }
                        }
                    }
                }
            }
        }

        //Delete the exisitng Saved Record for This Form
        DB::table('saved_form')->where([
            'form_id' => $request->route('formId'),
            'admin_id' => Auth::user()->admin_id,
            'company_id' => Auth::user()->company_id,
        ])->delete();

        //Send it to Admin
        $check = DB::table('sent_forms')->insert([

            'form_name' => $request->input('form_name'),
            'form_id' => $request->route('formId'),
            'user_id' => Auth::user()->id,
            'admin_id' => Auth::user()->admin_id,
            'company_id' => Auth::user()->company_id,
            'user_name' => Auth::user()->name,
            'user_form_name' => $request->input('user_form_name'),
            'data' => $request->input('data'),
            'isActive' => 1,
            'created_at' => NOW()
        ]);

        if($check == true)
        {
            return "Test Saved Successfully";
        }
        else
        {
            return "Test Saved Failed";
        }
        return "Test Saved Failed";
    }




    //=========================================
    //  Show the View of Sent Form
    //=========================================
    public function ShowViewOfSentForm(Request $request)
    {
        
        $sent_form = DB::table('sent_forms')->where([

            'id' => $request->route('formId'),
            'user_id' => Auth::user()->id,
            'admin_id' => Auth::user()->admin_id,
            'company_id' => Auth::user()->company_id,
            'isActive' => 1
        ])->get();

        if(!$sent_form->isEmpty())
        {
            return view('user.viewSentForm')->with(['form' => $sent_form[0]->data]);
        }
        
        return redirect('/user')->withErrors(["WrongInput" => "Cannot View Form"]);

    }



    //==========================================================
    //  DOWNLOAD RESOURCE
    //==========================================================

    public function download(Request $request)
    {
        $filename = $request->route('filename');
        // Check if file exists in app/storage/file folder
        $file_path = public_path() . "/content/" . $filename;
        
        $headers = array(
            'Content-Type' => 'application/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
          );
        if ( file_exists( $file_path ) ) {
            // Send Download
            return \Response::download( $file_path, $filename, $headers );
        } 
        else 
        {
            exit( 'Requested file does not exist on our server!' );
        }
    }

}
