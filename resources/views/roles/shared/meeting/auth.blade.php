<x-app no-navbar no-sidebar bare-content no-footer>
    <div class="nk-block nk-block-middle wide-xs mx-auto">
        <x-layout.alert />
        <div class="nk-block-head mt-5">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Continue your session</h5>
                <div class="nk-block-des">
                    <p>Access the Cogni™ Meet session platform through your session ID.</p>
                </div>

                <form action="{{ route('dashboard.session.verify') }}" method="POST" class="form-validate is-alter pt-3">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="sessionToken">Session ID</label>
                        </div>

                        <div class="form-control-wrap">
                            <input type="text"
                                class="form-control form-control-lg @error('token') is-invalid @enderror"
                                name="token"
                                value="{{ old('token') }}"
                                autocomplete="false" autofocus required id="sessionToken"
                                placeholder="Enter your sessions ID">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="emailAddress">Email address</label>
                        </div>

                        <div class="form-control-wrap">
                            <input
                                type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                autocomplete="email" autofocus required id="emailAddress"
                                placeholder="Enter your email address">
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block">Join Session</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app>
