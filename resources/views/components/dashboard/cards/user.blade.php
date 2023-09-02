@props([
    'icon' => 'users-fill',
    'label' => 'Total Users',
    'count' => 0,
    'percentage' => 0,
])
<div class="col-sm-6 col-lg-6 col-xxl-6">
    <div class="card card-bordered">
        <div class="card-inner">
            {{-- Icon --}}
            <div class="float-right">
                <em class="icon ni ni-{{ $icon }}-fill" style="font-size: 100px; color: #5CD0B0;"></em>
            </div>
            {{-- Title --}}
            <div class="card-title-group align-start mb-2">
                <div class="card-title">
                    <h6 class="title">{{ $label }}</h6>
                </div>
            </div>
            {{-- Amount and percentage --}}
            <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                <div class="nk-sale-data">
                    <span class="amount">{{ $count }}</span>
                    <span class="sub-title">
                        <span class="change up text-success">
                            <em class="icon ni ni-arrow-long-up"></em> {{ $percentage }}%
                        </span>
                        since last week
                    </span>
                </div>
            </div>
        </div>
    </div><!-- .card -->
</div>
