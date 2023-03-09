<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
class OtpController extends Controller
{
    public function create()
    {
        return view('otp.create');
    }

    protected function gtClient()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("f90afa72", "7zUS6i1hmc3kY5Zb");
        $client = new \Vonage\Client(new \Vonage\Client\Credentials\Container($basic));

        return $client;
    }
    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
        ]);

        $client = $this->gtClient();


        $request = new \Vonage\Verify\Request($request->post('phone_number'),"ALwrifi");
        $request->setCodeLength(4);
        $request->setCountry('YE');

        //dd($client);
        $response = $client->verify()->start($request);
       
       

        Session::put('vonage.verify.requestId',$response->getRequestId());

       return redirect()->route('otp.verify');
    }

    public function verifyForm()
    {
        return view('otp.verify');
    }

    public function verify(Request $request)
    {
        $request-> validate([
            'code' => 'required',
        ]);

        $client = $this->gtClient();

        try{

            $requestId = Session::get('vonage.verify.requestId');
            //$result = $client->verify()->check($requestId, $request->post('code'));
            $result = $client->verify()->check($requestId, $request->post('code'));


        }catch(\Vonage\Client\Exception\Request $e){

            return redirect()->back()->with('error', $e->getMessage());
        }

        Session::forget('vonage.verify.requestId');

        return "تم التحقق بنجاح";
    }
}
