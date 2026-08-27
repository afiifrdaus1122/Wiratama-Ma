<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RfqMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Product $product,
        public array $details,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ($this->details['language'] === 'en' ? 'Request for Quotation (RFQ) - ' : 'Permohonan Penawaran Harga (RFQ) - ') . $this->product->name . ' - ' . $this->details['company'],
            replyTo: [$this->details['email']],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.rfq');
    }
}