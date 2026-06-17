@extends('layouts.app')

@section('content')
    <h1>Checkout</h1>

    @if(empty($cart))
        <p>Your cart is empty. <a href="{{ route('shop.index') }}">Go shopping</a>.</p>
    @else
        <form method="POST" action="{{ route('shop.checkout.post') }}">
            @csrf
            <div style="margin-bottom:1rem;max-width:520px;">
                <label>Name<br><input name="name" value="{{ old('name') }}" style="width:100%;padding:.6rem;border-radius:8px;border:1px solid rgba(255,255,255,0.04);background:var(--glass);color:inherit"></label>
            </div>
            <div style="margin-bottom:1rem;max-width:520px;">
                <label>Email<br><input name="email" value="{{ old('email') }}" style="width:100%;padding:.6rem;border-radius:8px;border:1px solid rgba(255,255,255,0.04);background:var(--glass);color:inherit"></label>
            </div>
            <div style="margin-bottom:1rem;max-width:520px;">
                <label>Address<br><textarea name="address" style="width:100%;min-height:90px;padding:.6rem;border-radius:8px;border:1px solid rgba(255,255,255,0.04);background:var(--glass);color:inherit;resize:none">{{ old('address') }}</textarea></label>
            </div>

            <h3>Order</h3>
            <ul>
                    @php $total = 0; @endphp
                @foreach($cart as $pid => $qty)
                        @php $p = $products->get($pid); if(!$p) continue; $line = $p->price * $qty; $total += $line; @endphp
                        <li style="margin-bottom:.5rem;">
                            @php $thumb = $p->image ?: 'https://via.placeholder.com/64?text=No'; @endphp
                            <img src="{{ $thumb }}" alt="" style="height:32px;width:32px;object-fit:cover;margin-right:.5rem;vertical-align:middle;" onerror="this.onerror=null;this.src='https://via.placeholder.com/64?text=No'">
                            {{ $p->name }} x {{ $qty }} — €{{ number_format($line,2) }}
                        </li>
                @endforeach
                    </ul>
                    <p><strong>Total: €{{ number_format($total,2) }}</strong></p>
            <button type="submit" class="btn btn-primary">Place order</button>
        </form>
    @endif
@endsection
