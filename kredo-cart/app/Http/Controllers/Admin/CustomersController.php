<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomersController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->customer = new User();
    }

    public function index()
    {
        $customers = $this->customer->all();

        return view('admin.customers.index')->with('customers', $customers);

    }

    public function destroy($id)
    {
        $customer = $this->customer->findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }

}
