<div class="nk-sidebar nk-sidebar-fixed is-dark" style="background-color: #253668;" data-content="sidebarMenu">
    <x-layout.sidebar.controls />

    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    @role('super_admin')
                        <x-layout.sidebar.super-admin />
                    @endrole
                    @role('admin')
                        <x-layout.sidebar.admin />
                    @endrole
                    @role('provider')
                        <x-layout.sidebar.provider />
                    @endrole
                    @role('client')
                        <x-layout.sidebar.client />
                    @endrole
                </ul>
            </div>
        </div>
    </div>
</div>
