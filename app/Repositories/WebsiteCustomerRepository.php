<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Traits\ImageTrait;

class WebsiteCustomerRepository
{
    use ImageTrait;

    public function all()
    {
        return Customer::active()->orderBy('ordering', 'DESC')->get();
    }

    public function activeCustomer($data = [])
    {
        return Customer::active()->latest()->get();
    }

    public function store($request)
    {
        $ourCustomer        = new Customer;
        if (isset($request->image)) {
            $response           = $this->saveImage($request->image);
            $images             = $response['images'];
            $ourCustomer->image = $images;
        }
        $ourCustomer->title = $request->title;
        $ourCustomer->save();

        return $ourCustomer;
    }

    public function find($id)
    {
        return Customer::find($id);
    }

    public function update($request, $id)
    {
        $ourCustomer        = Customer::find($id);
        if (isset($request->image)) {
            $response           = $this->saveImage($request->image);
            $images             = $response['images'];
            $ourCustomer->image = $images;
        }
        $ourCustomer->title = $request->title;
        $ourCustomer->save();

        return $ourCustomer;
    }

    public function status($data)
    {
        $ourCustomer         = Customer::find($data['id']);
        $ourCustomer->status = $data['status'];
        $ourCustomer->save();

        return $ourCustomer;
    }

    public function destroy($id)
    {
        return Customer::destroy($id);
    }
}
