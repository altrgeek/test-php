<x-dashboard title="Dashboard Details" description="Welcome to Cogni&trade; XR Health Dashboard.">
    {{-- Additonal header content --}}
    <x-slot name="header">
        <div class="toggle-wrap nk-block-tools-toggle">
            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                    class="icon ni ni-more-v"></em></a>
            <div class="toggle-expand-content" data-content="pageMenu">
                <ul class="nk-block-tools g-3">
                    <li > 
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Update Profile Now</a>
                    </li>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                data-toggle="dropdown"><em
                                    class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span
                                        class="d-none d-md-inline">Last</span> 30 Days</span><em
                                    class="dd-indc icon ni ni-chevron-right"></em></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    @if (Session::has('token'))
                                        <input type="hidden" id="getSessionToken"
                                            data-token="{{ Session::get('token') }}">
                                    @endif
                                    <li><a href="#"><span>Last 30 Days</span></a></li>
                                    <li><a href="#"><span>Last 6 Months</span></a></li>
                                    <li><a href="#"><span>Last 1 Years</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    {{-- Main content --}}
    <div class="row g-gs">
        <div class="col-xxl-6">
            <div class="row g-gs">
                <x-dashboard.cards.user icon="users" label="Total Users" :count="$users" percentage="2.45" />
                <x-dashboard.cards.user icon="user-list" label="Total Providers" :count="$providers" percentage="2.45" />
                <x-dashboard.cards.user icon="users" label="Total Clients" :count="$clients" percentage="2.45" />
            </div>
        </div>
    </div>
    <div class="nk-block-head nk-block-head-sm">
        <div class="row nk-block-between pt-5 mt-3 d-flex">
            <div class="col-md-3 nk-block-head-content ">
                <h3 class="nk-block-title page-title"> Branding Details</h3>
                <div class=" p-1 pt-3 m-2 card card-bordered brading-preview "
                    style="background:{{ $admin->secondary_color }}; border-radius:5px">
                    <ul class="nk-menu">
                        <li class="nk-menu-item ">
                            <a href="#" class="nk-menu-link" data-bs-original-title="" title="">
                                <div>
                                    <img class="logo-dark logo-img" src="{{ $admin->logo }}"
                                        srcset="{{ $admin->logo }} 2x" alt="logo-dark" />
                                    <img class="logo-light logo-img" src="{{ $admin->logo }}"
                                        srcset="{{ $admin->logo }} 2x" alt="logo" />

                                </div>
                            </a>

                        </li>
                        <li class="nk-menu-item active current-page">
                            <a class="nk-menu-link dynamic-link " data-bs-original-title="" title="">
                                <span class="nk-menu-icon"><em class="icon ni ni-property"></em></span>
                                <span class="nk-menu-text"> Active Link Color</span>
                            </a>
                        </li>
                        <li class="nk-menu-item ">
                            <a href="#" class="nk-menu-link dynamic-link ">
                                <span class="nk-menu-icon"><em class="icon ni ni-property"></em></span>
                                <span class="nk-menu-text"> Link Color</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9  nk-block-head-content " style="width:100%">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form action="{{ route('admin.update_branding') }}" method="Post" enctype="multipart/form-data">
                                @csrf
                                <span class="sub-title"><span class=" overline-title" style="font-size:13px;">Update
                                        Your
                                        Branding</span> (To see change must submit first)</span>
                                <div class="row gy-4">
                                    <div class="col-md-4">
                                        <label for="exampleColorInput" class="form-label">Primary Color <span
                                                style="color:red !important">*</span></label>
                                        <input type="color" class="form-control form-control-color"
                                            id="exampleColorInput" value="{{ $admin->primary_color }}" name="primary"
                                            title="Choose your color" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleColorInput" class="form-label">Secondary Color <span
                                                style="color:red !important">*</span></label>
                                        <input type="color" class="form-control form-control-color"
                                            id="exampleColorInput" value="{{ $admin->secondary_color }}"
                                            name="secondary" title="Choose your color" required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label class="form-label" for="default-01"> Text
                                                Color <span style="color:red !important">*</span></label>
                                            <input type="color" class="form-control form-control-color"
                                                id="exampleColorInput" value="{{ $admin->text_color }}"
                                                name="text" title="Choose your color" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Brand logo <span
                                                    class="sub-title">
                                                    (Only in PNG format)</span></label>
                                            <input class="form-control" type="file" id="formFile"  accept="image/x-png" name="logo">
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mb-3">Update Branding</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>
