<h1>Invoice #{{$invoice->id}}</h1>

<p>Client: {{$client->name}}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Description</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{$item->description}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->unit_price}}</td>
                <td>{{$item->quantity * $item->unit_price}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p>Subtotal: {{$invoice->subtotal}}</p>
<p>Tax: {{$invoice->tax}}</p>
<p>Total: {{$invoice->total}}</p>
<p>Status: {{$invoice->status}}</p>