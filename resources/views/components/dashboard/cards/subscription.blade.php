@props([
    'image' => asset('/images/icons/plan-s1.svg'),
    'name' => 'Lorem Subscription',
    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, laborum.',
    'price' => 0.0,
    'pricing' => 'year',
    'details' => '1 user, billed yearly',
    'subscribeUrl' => route('admin.dashboard'),
    'subscribeText' => 'Buy Now',
    'active' => false,
])
<div class="col-md-6 col-xxl-3">
    <div class="card card-bordered pricing text-center">
        @if ($active)
            <span class="pricing-badge badge badge-primary">Purchased</span>
        @endif
        <div class="pricing-body">
            <div class="pricing-media">
                <img src="/images/icons/plan-s1.svg" alt="">
            </div>
            <div class="pricing-title w-220px mx-auto">
                <h5 class="title">{{ $name }}</h5>
                <span class="sub-text">{{ $description }}</span>
            </div>
            <div class="pricing-amount">
                <div class="amount">${{ $price }} <span>/{{ $pricing }}</span></div>
                <span class="bill">{{ $details }}</span>
            </div>
            <div class="pricing-action">
                <a href="{{ $subscribeUrl }}" class="btn btn-primary">{{ $subscribeText }}</a>
            </div>
        </div>
    </div>
</div>
