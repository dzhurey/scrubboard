<?php

return [
    "phone_number_not_number" => "Nomor telepon harus berupa nomor telepon yang valid",
    "cannot_delete_order_has_invoice" => "Order memiliki invoice, hapus invoice terlebih dahulu untuk menghapus order ini",
    "cannot_update_order_has_invoice" => "Order memiliki invoice, order ini tidak dapat diubah",
    'person_not_courier' => 'role user bukan sebagai kurir',
    'data_not_found' => 'data tidak ditemukan',
    'item_has_transaction' => 'Item memiliki transaksi, hapus transaksi terlebih dahulu untuk menghapus item ini',
    'cannot_cancel_item_on_invoice' => 'Item tidak dapat di-cancel saat di invoice',
    "cannot_cancel_order_has_invoice" => "Order memiliki invoice, hapus invoice terlebih dahulu untuk cancel order ini",
    "cannot_cancel_order_has_picked" => "Item di order ini telah di-pickup, tidak bisa cancel order ini",
    "cannot_cancel_pickup_has_picked" => "Item di pickup ini telah di-pickup, tidak bisa cancel pickup ini",
    "cannot_cancel_delivery_has_picked" => "Item di delivery ini telah di-deliver, tidak bisa cancel delivery ini",
    "cannot_delete_customer_has_transaction" => "Customer ini memiliki transaksi, tidak bisa dihapus",
    "cannot_delete_category_has_item" => "Kategori ini telah dipasang di item, tidak bisa dihapus",
    "cannot_delete_sub_category_has_item" => "Sub Kategori ini telah dipasang di item, tidak bisa dihapus",
    "cannot_delete_courier_has_schedule" => "Kurir ini memiliki jadwal, tidak bisa dihapus",
    "cannot_delete_vehicle_has_schedule" => "Kendaraan ini memiliki jadwal, tidak bisa dihapus",
    "cannot_delete_bank_has_payment" => "Bank memiliki pembayaran, tidak bisa dihapus",
    "cannot_delete_agent_has_transaction" => "Agen ini memiliki transaksi, tidak bisa dihapus",
    "bor_must_be_unique" => "BOR number has been already used in transaction",
];
