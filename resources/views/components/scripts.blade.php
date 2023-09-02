<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script> -->
<script src="{{ asset('assets/js/bundle.js?ver=2.9.0') }}"></script>
<script src="{{ asset('assets/js/scripts.js?ver=2.9.0') }}"></script>
<script src="{{ asset('assets/js/libs/fullcalendar.js?ver=2.9.0') }}"></script>
<!-- <script src="{{ asset('assets/js/apps/calendar.js?ver=2.9.0') }}"></script> -->
<script src="{{ asset('assets/js/charts/gd-default.js?ver=2.9.0') }}"></script>

<script type="text/javascript">
    window.__cogni = typeof window.__cogni === "object" ? window.__cogni : {};
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $(".subscribe_btn").click(function () {
            let subscription_id = $(this).attr('data-subscription-id');
            let subscription_name = $(this).attr('data-subscription-name');
            let subscription_price = $(this).attr('data-subscription-price');
            let subscription_duration_number = $(this).attr('data-subscription-duration-number');
            let subscription_duration = $(this).attr('data-subscription-duration');

            let subscribe_modal = $("#subscribeModal").attr("data-subscription-id", subscription_id);

            $("#subscriptionID").val(subscription_id);
            $("#subscriptionNAME").val(subscription_name);
            $("#subscriptionNAMEDisplay").val(subscription_name);
            $("#subscriptionPRICE").val(subscription_price);
            $("#subscriptionNumber").val(subscription_duration_number);
            $("#subscriptionDuration").val(subscription_duration);

            subscribe_modal.modal('show');
        });

        $(".package_btn").click(function () {
            let package_id = $(this).attr('data-package-id');
            let package_title = $(this).attr('data-package-title');
            let package_sessions = $(this).attr('data-package-sessions');
            let package_price = $(this).attr('data-package-price');

            let package_modal = $("#PackageModal").attr("data-package-id", package_id);

            $("#PackageID").val(package_id);
            $("#PackageTitle").val(package_title);
            $("#packageTitleDisplay").val(package_title);
            $("#PackagePRICE").val(package_price);
            $("#PackageSessions").val(package_sessions);

            package_modal.modal('show');
        });

        $("#PayNowBtn").click(function () {
            let appointment_id = $(this).attr('data-appointment-id');
            let order_id = $(this).attr('data-order-id');
            let order_amount = $(this).attr('data-order-amount');

            let pay_now_modal = $("#PayNowModal").attr("data-order-id", order_id);
            pay_now_modal.attr("data-order-amount", order_amount);
            pay_now_modal.attr("data-appointment-id", appointment_id);

            $("#order_id").val(order_id);
            $("#order_amount").val(order_amount);

            pay_now_modal.modal('show');
        });
    });

    @auth
        @php
            $user = Auth::user();
            $user->role = $user->getRole();
        @endphp
        window.user = {!! $user->makeHidden('roles')->toJson() !!};
    @else
        window.user = undefined;
    @endauth

    window.VITE_PUSHER_APP_KEY = "{!! config('broadcasting.connections.pusher.key') !!}";
    window.VITE_PUSHER_HOST = "{!! config('broadcasting.connections.pusher.options.client.host') !!}";
    window.VITE_PUSHER_PORT = {!! config('broadcasting.connections.pusher.options.client.port') !!};
    window.VITE_PUSHER_SCHEME = "{!! config('broadcasting.connections.pusher.options.client.scheme') !!}";
    window.VITE_APP_URL = "{!! config('app.url') !!}";
</script>
