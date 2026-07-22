<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrdersController extends Controller
{
    private $order;
    //

    public function __construct()
    {
        $this->order = new Order;
    }

    public function index()
    {
        $orders = $this->order->with('user')->get();

        return view('admin.orders.index')->with('orders', $orders);
    }



}
