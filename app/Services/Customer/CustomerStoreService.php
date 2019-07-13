<?php

namespace App\Services\Customer;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Customer;
use App\Address;

class CustomerStoreService extends BaseService
{
    protected $customer;
    protected $address;

    public function __construct(
        Customer $customer,
        Address $address
    ) {
      $this->customer = $customer;
      $this->address = $address;
    }

    public function perform(Array $attributes)
    {
        DB::beginTransaction();
        try {
            $this->createCustomer($attributes);

            if (!empty($this->customer->id)) {
                $this->createBillingAddress($attributes);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    private function createCustomer(Array $attributes)
    {
        $this->customer = $this->assignAttributes($this->customer, $attributes);
        $this->customer->save();
    }

    private function createAddress(Array $attributes)
    {
        $this->address = $this->assignAttributes($this->address, $attributes);
        $this->address->save();
    }

    private function createBillingAddress(Array $attributes)
    {
        $address_meta = $this->generateAddressMeta($attributes, 'billing');
        $this->createAddress($address_meta);
    }

    private function createShippingAddress(Array $attributes)
    {
        $address_meta = $this->generateAddressMeta($attributes, 'shipping');
        $this->createAddress($address_meta);
    }

    private function generateAddressMeta(Array $attributes, String $prefix)
    {
        $is_billing = $prefix === 'billing';
        $is_shipping = $prefix === 'shipping';

        return [
            'customer_id' => $this->customer->id,
            'is_billing' => $is_billing,
            'is_shipping' => $is_shipping,
            'description' => $attributes[$prefix.'_address'],
            'district' => $attributes[$prefix.'_district'],
            'city' => $attributes[$prefix.'_city'],
            'country' => $attributes[$prefix.'_country'],
            'zip_code' => $attributes[$prefix.'_zip_code'],
        ];
    }
}
