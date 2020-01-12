<?php

return [
    "phone_number_not_number" => "Phone number must be a valid phone number",
    "cannot_delete_order_has_invoice" => "This order has invoice, delete invoice first to delete this order",
    "cannot_update_order_has_invoice" => "This order has invoice, this order cannot be updated",
    'person_not_courier' => 'user role is not a courier',
    'data_not_found' => 'data not found',
    'item_has_transaction' => 'Item has transaction, delete transaction first to delete this item',
    'cannot_cancel_item_on_invoice' => 'Item could not be canceled on invoice',
    "cannot_cancel_order_has_invoice" => "This order has invoice, delete invoice first to cancel this order",
    "cannot_cancel_order_has_picked" => "Items on this order has picked up, cannot cancel this order",
    "cannot_cancel_pickup_has_picked" => "Item on this pickup has picked up, cannot cancel this pickup",
    "cannot_cancel_delivery_has_picked" => "Item on this delivery has delivered, cannot cancel this delivery",
    "cannot_delete_customer_has_transaction" => "Customer has transaction, cannot be deleted",
    "cannot_delete_category_has_item" => "Category has item, cannot be deleted",
    "cannot_delete_sub_category_has_item" => "Sub category has item, cannot be deleted",
    "cannot_delete_courier_has_schedule" => "Courier has schedule, cannot be deleted",
    "cannot_delete_vehicle_has_schedule" => "Vehicle has schedule, cannot be deleted",
    "cannot_delete_bank_has_payment" => "Bank has payment, cannot be deleted",
    "cannot_delete_agent_has_transaction" => "Agent has transaction, cannot be deleted",
    "bor_must_be_unique" => "BOR must be unique",
    "more_than_amount" => "More than transaction amount",
    "not_equal_with_lines" => "Not equal with amount in lines",
    "files_must_not_more_than_10" => "Photo must not more than 10",
    "promo_does_not_exist" => "Promo code does not exist",
    "promo_exceeds_quota" => "Promo code exceeds quota",
    "address_is_default" => "Address is a default address",
    "address_has_schedules" => "Address has schedules, delete schedules first to delete this address",
    "transaction_not_use_own_address" => "Transaction not use agent address, must define customer address used",
    "address_is_not_shipping" => "Addres is not a shipping address",
];
