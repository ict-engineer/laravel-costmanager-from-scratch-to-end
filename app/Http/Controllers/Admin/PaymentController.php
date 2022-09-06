<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Jenssegers\Agent\Agent;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    //Check if user has list permission
    public function __construct()
    {
        $this->middleware(['permission:List Payments']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $agent = new Agent();
        
        $payments = Payment::orderby('id')->get();
        
        if($agent->isMobile())
            $i = -1;
        else
            $i = (request()->input('page', 1) - 1) * 10;
        return view('admin.payment.index',compact('payments'))
            ->with('i', $i);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name'                 => [
                'required',
                Rule::unique('payments'),
            ],
            'numberofusers'         => 'required',
            'price'         => 'required',
            'currency'         => 'required',
            'country'         => 'required',
            'description'      => 'required',
        ]);
        $data = $request->input();
        Payment::create([
            'name' => $data['name'],
            'numberofusers' => $data['numberofusers'],
            'price' => $data['price'],
            'currency' => $data['currency'],
            'country' => $data['country'],
            'description' => $data['description'],
        ]);
        return redirect()->route('payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $payment = Payment::find($id);
        return view('admin.payment.edit')->with('payment', $payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'                 => [
                'required',
                Rule::unique('payments')->ignore($id),
            ],
            'numberofusers'         => 'required',
            'price'         => 'required',
            'currency'         => 'required',
            'country'         => 'required',
            'description'      => 'required',
        ]);
        //
        $payment = Payment::find($id);
        $payment->name = $request->input('name');
        $payment->numberofusers = $request->input('numberofusers');
        $payment->price = $request->input('price');
        $payment->currency = $request->input('currency');
        $payment->country = $request->input('country');
        $payment->description = $request->input('description');
        $payment->update();
        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $payment = Payment::find($id);
        $payment->delete();
        return redirect()->route('payments.index');
    }
}
