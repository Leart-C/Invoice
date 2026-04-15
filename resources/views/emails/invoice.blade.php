<x-mail::message>
# Invoice {{ $invoice->invoice_number }}

Dear {{ $client->name }},

Please find attached your invoice **{{ $invoice->invoice_number }}** from Invoice Tracker.

| | |
|---|---|
| **Invoice Number** | {{ $invoice->invoice_number }} |
| **Issue Date** | {{ $invoice->issue_date->format('M d, Y') }} |
| **Due Date** | {{ $invoice->due_date->format('M d, Y') }} |
| **Total Amount** | ${{ number_format($invoice->total, 2) }} |
| **Status** | {{ ucfirst($invoice->status) }} |

The PDF invoice is attached to this email.

<x-mail::button :url="$invoiceUrl">
View Invoice Online
</x-mail::button>

If you have any questions about this invoice, please don't hesitate to reach out.

Thanks,
Invoice Tracker
</x-mail::message>