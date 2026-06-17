@extends('layouts.app')

@section('content')
    <h1>Thank you</h1>
    <p>Order #{{ $order->id }} placed. Total: €{{ number_format($order->total,2) }}</p>
    <p><a href="{{ route('shop.index') }}">Continue shopping</a></p>
@endsection
