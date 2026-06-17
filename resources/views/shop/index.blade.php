@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="margin-bottom:.75rem;">Shop</h1>

    <div class="products-grid">
        @foreach($products as $product)
            @php $img = $product->image ?: 'https://via.placeholder.com/300?text=No+Image'; @endphp
            <div class="card">
                <div class="media" style="background-image:url('{{ $img }}');"></div>
                <div class="meta stack">
                    <h3>{{ $product->name }}</h3>
                    <p class="muted" style="margin-top:.25rem;">{{ $product->description }}</p>
                    <p class="price" style="margin-top:.5rem;">€{{ number_format($product->price,2) }}</p>

                    <form method="POST" action="{{ route('shop.add') }}" class="row" style="margin-top:.6rem;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" style="width:66px;padding:.3rem;border-radius:6px;border:1px solid rgba(255,255,255,0.06);background:var(--glass);color:inherit">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
