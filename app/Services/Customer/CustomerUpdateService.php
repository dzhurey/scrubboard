<?php

namespace App\Services\Customer;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Services\Customer\CustomerStoreService;
use App\Customer;
use App\Address;

class CustomerUpdateService extends CustomerStoreService
{
    protected $customer;
    protected $billing_address;
    protected $shipping_address;

    public function perform(Array $attributes, Customer $customer=null)
    {
        $this->customer = $customer;
        $this->billing_address = $customer->billingAddress();
        $this->shipping_address = $customer->shippingAddress();

        DB::beginTransaction();
        try {
            $this->createCustomer($attributes);

            if (!empty($this->customer->id)) {
                $this->createBillingAddress($attributes);
            }

            if (!empty($this->customer->id) && !$this->is_same_address) {
                $this->createShippingAddress($attributes);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createBillingAddress(Array $attributes)
    {
        $address_meta = $this->generateAddressMeta($attributes, 'billing');

        if($this->is_same_address) {
            $address_meta['is_shipping'] = true;
        }

        $this->billing_address = $this->assignAttributes($this->billing_address, $address_meta);
        $this->billing_address->save();
    }

    private function createShippingAddress(Array $attributes)
    {
        $address_meta = $this->generateAddressMeta($attributes, 'shipping');

        $this->shipping_address = $this->assignAttributes($this->shipping_address, $address_meta);
        $this->shipping_address->save();
    }
}
