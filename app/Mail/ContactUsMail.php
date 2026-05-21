<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    // المتغير الذي سيحمل البيانات للقالب
    public $data;

    /**
     * استقبال البيانات عند استدعاء الكلاس
     */
    public function __construct($details)
    {
        $this->data = $details;
    }

    /**
     * تعريف عنوان الإيميل (الطريقة الحديثة)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Massege from website: ' . $this->data['name'],
        );
    }

    /**
     * تعريف ملف التصميم (الطريقة الحديثة)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact', // هنا تأكدي أن الملف موجود في resources/views/emails/contact.blade.php
        );
    }

    public function attachments(): array
    {
        return [];
    }
}