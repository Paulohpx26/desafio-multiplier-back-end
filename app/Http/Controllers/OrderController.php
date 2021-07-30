<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use stdClass;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = array();

        if ($request->table_id) $filter['table_id'] = (int)$request->table_id;

        if ($request->client_id) $filter['client_id'] = (int)$request->client_id;

        if ($request->dateFilter) {
            $date = Carbon::parse($request->date) ?? Carbon::now();
            $timezone = $request->timezone ?? 'America/Sao_Paulo';

            switch ($request->dateFilter) {
                case 'month':
                    $startDate = $date->copy()->startOfMonth();
                    $endDate = $date->copy()->endOfMonth();
                    break;
                case 'week':
                    $startDate = $date->copy()->startOfWeek();
                    $endDate = $date->copy()->endOfWeek();
                    break;
                case 'day':
                    $startDate = $date->copy()->startOfDay();
                    $endDate = $date->copy()->endOfDay();
                    break;
                default:
                    break;
            }
            return Order::where($filter)
                ->where('created_at', '>=', Carbon::createFromFormat(
                    'Y-m-d H:i:s', $startDate
                )->timezone($timezone))
                ->where('created_at', '<=', Carbon::createFromFormat(
                    'Y-m-d H:i:s', $endDate)
                ->timezone($timezone))
                ->get();
        } else
            return Order::where($filter)->get();
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
            'status' => 'in:pending,processing,completed,canceled',
            'waiter_id' => 'required|integer'
        ]);

        return Order::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::find($id);
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
            'status' => 'in:pending,processing,completed,canceled',
            'waiter_id' => 'integer'
        ]);

        $order = Order::find($id);

        if (!$order)
            return response([
                'message' => 'Order not found'
            ], 400);

        $order->update($request->all());
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Order::destroy($id);
    }
}
