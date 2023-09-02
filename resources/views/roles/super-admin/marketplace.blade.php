<x-dashboard title="Marketplace Options">
    <x-slot name="header">
        <x-dashboard.widgets.button label="New Treatment URL" />
    </x-slot>

    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer">
        <thead>
            <tr>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Name</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">URL</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Last Updated</span>
                </th>
                <th class="nk-tb-col nk-tb-col-tools"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($options as $option)
                <tr class="nk-tb-item {{ $loop->even ? 'even' : 'odd' }}">
                    <td class="nk-tb-col">
                        <span>{{ $option->name }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <a
                            href="{{ $option->url }}"
                            target="_blank"
                            rel="noreferrer"
                        >
                            {{ $option->url }}
                        </a>
                    </td>
                    <td class="nk-tb-col">
                        <span>{{ $option->prettyUpdated }}</span>
                    </td>

                    <td class="nk-tb-col nk-tb-col-tools">
                        <div class="drodown">
                            <a
                                href="#"
                                class="dropdown-toggle btn btn-icon btn-trigger"
                                data-toggle="dropdown"
                            >
                                <em class="icon ni ni-more-v"></em>
                            </a>

                            <!-- Content -->
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul
                                    class="link-list-opt no-bdr"
                                    data-resource="{{ $option->toJson() }}"
                                >
                                    <!-- Update -->
                                    <li>
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#editResourceModal"
                                            onclick="populateFields(this)"
                                        >
                                            <em class="icon ni ni-edit"></em>
                                            <span>Edit</span>
                                        </a>
                                    </li>

                                    <!-- Delete -->
                                    <li>
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#deleteResourceModal"
                                            onclick="populateFields(this)"
                                        >
                                            <em class="icon ni ni-trash"></em>
                                            <span>Delete</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <x-slot name="modals">
        <!-- Create marketplace option modal -->
        <x-dashboard.widgets.modal
            title="Add Treatment URL"
            :url="route('super_admin.dashboard.marketplace.create')"
        >
            @production
                @php
                    $__defaults = [
                        'name' => old('name'),
                        'url'  => old('url'),
                    ];
                @endphp
            @else
                @php
                    $faker = Faker\Factory::create();
                    $__defaults = [
                        'name' => ucfirst($faker->words(random_int(2, 4), true)),
                        'url'  => $faker->url(),
                    ];
                @endphp
            @endproduction

            <!-- Option Name -->
            <x-dashboard.widgets.form.input
                label="Name"
                name="name"
                id="marketplaceOptionName"
                wrapperClass="col-md-6"
                value="{{ $__defaults['name'] }}"
                placeholder="Enter marketplace option name"
                required
            />

            <!-- Option URL -->
            <x-dashboard.widgets.form.input
                label="URL"
                name="url"
                id="marketplaceOptionUrl"
                wrapperClass="col-md-6"
                value="{{ $__defaults['url'] }}"
                placeholder="Enter marketplace option name"
                required
            />
        </x-dashboard.widgets.modal>

        <!-- Edit marketplace option modal -->
        <x-dashboard.widgets.modal
            title="Editor Treatment URL"
            :url="route('super_admin.dashboard.marketplace.update', ':id')"
            method="PUT"
            action="Update"
            id="edit"
        >
            <!-- Option Name -->
            <x-dashboard.widgets.form.input
                label="Name"
                name="name"
                id="editMarketplaceOptionName"
                wrapperClass="col-md-6"
                value=""
                placeholder="Enter marketplace option name"
                required
            />

            <!-- Option URL -->
            <x-dashboard.widgets.form.input
                label="URL"
                name="url"
                id="editMarketplaceOptionUrl"
                wrapperClass="col-md-6"
                value=""
                placeholder="Enter marketplace option name"
                required
            />
        </x-dashboard.widgets.modal>
    </x-slot>

    <!-- Delete resource modal -->
        <x-dashboard.widgets.modal
            title="Delete Marketplace Option"
            method="DELETE"
            :url="route('super_admin.dashboard.marketplace.delete', ':id')"
            action="Delete"
            id="delete"
            noHeader
        >
            <h5 class="text-center col-12 my-5">
                Are you sure want to delete this marketplace option?
            </h5>
        </x-dashboard.widgets.modal>

    <x-slot name="scripts">
        <script type="text/javascript">
            const populateFields = (that) => {
                const option = $(that).parent().parent().data('resource');

                const {id, name, url} = option

                const editUrl = $('#editResourceModalForm').attr('action');
                const deleteUrl = $('#deleteResourceModalForm').attr('action');

                if (editUrl) $('#editResourceModalForm').attr('action', editUrl.replace(':id', id));
                if (deleteUrl) $('#deleteResourceModalForm').attr('action', deleteUrl.replace(':id', id));

                $('#editMarketplaceOptionNameInputField').val(name);
                $('#editMarketplaceOptionUrlInputField').val(url);
            }
        </script>
    </x-slot>
</x-dashboard>
