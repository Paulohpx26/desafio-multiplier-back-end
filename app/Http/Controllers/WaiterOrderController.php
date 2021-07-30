<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaiterOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Order::where([
            ['status', 'pending'],
            ['waiter_id', $request->user()->id],
        ])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'table_id' => 'required|integer',
            'menu_id' => 'required|integer',
            'quantity' => 'required|integer',
            'status' => 'in:pending,processing,completed,canceled'
        ]);
        $request->waiter_id = $request->user()->id;

        return Order::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order->waiter_id != $request->user()->id)
        return response([
            'message' => 'Not authorized'
        ], 403);

        return $order;
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
        $request->validate([
            'client_id' => 'integer',
            'table_id' => 'integer',
            'menu_id' => 'integer',
            'quantity' => 'integer',
            'status' => 'in:pending,processing,completed,canceled'
        ]);

        $order = Order::find($id);

        if (!$order)
            return response([
                'message' => 'Order not found'
            ], 400);

        if ($order->waiter_id != $request->user()->id)
            return response([
                'message' => 'Not authorized'
            ], 403);

        $order->update($request->all());
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order)
            return response([
                'message' => 'Order not found'
            ], 400);

        if ($order->waiter_id != $request->user()->id)
            return response([
                'message' => 'Not authorized'
            ], 403);

        $order->status = 'canceled';
        return $order->save();
    }
}
