<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RfqOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'RFQ ' . ($this->order->quotation_number ?: $this->order->invoice_number) . ' - ' . $this->order->company_name,
            replyTo: [$this->order->email],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.rfq_order');
    }
}