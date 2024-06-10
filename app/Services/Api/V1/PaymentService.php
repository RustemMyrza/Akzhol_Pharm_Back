<?php

declare(strict_types=1);

namespace App\Services\Api\V1;

use App\Models\Payment;

class PaymentService
{
    public function create(array $data)
    {
        return Payment::query()
            ->create([
                'invoice_id' => invoiceIdGenerate(),
                'order_id' => $data['order_id'],
                'user_id' => $data['user_id'],
                'amount' => $data['amount'],
                'description' => 'Оплата'
            ]);
    }

    public function update($data)
    {
        $payment = Payment::query()
            ->where('invoice_id', '=', $data['invoiceId'])
            ->where('status', '=', 0)
            ->first();

        if ($payment){
            $payment->status = $data['status'];
            $payment->response = json_encode($data);
            $payment->save();
            return $payment;
        }

        return null;
    }
}
