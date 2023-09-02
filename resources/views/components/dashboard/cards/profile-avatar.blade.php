<div class="user-card">
    <div class="user-avatar bg-primary">
        <span>
            <img src="{{ $avatar ? asset($avatar) : '' }}" />
        </span>
    </div>
    <div class="user-info">
        <span class="lead-text">{{ $name }}</span>
        <span class="sub-text">{{ $email }}</span>
    </div>

    {{-- settings dropdown (avatar) --}}
    <div class="user-action">
        <div class="dropdown">
            <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown" href="#">
                <em class="icon ni ni-more-v"></em>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <ul class="link-list-opt no-bdr">
                    <li>
                        <a href="#" id="profileAvatarOpener">
                            <em class="icon ni ni-camera-fill"></em>
                            <span>Change Photo</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <form
        action="{{ route('dashboard.profile.avatar') }}"
        method="POST"
        id="profileAvatarEditForm"
        enctype="multipart/form-data"
        novalidate="novalidate"
    >
        @method('PATCH')
        @csrf

        <input
            type="file"
            name="avatar"
            id="avatarInputField"
            accept=".png,.jpg,.jpeg,.webp"
            style="display: none; visibility: hidden; opacity: 0; height: 0; width: 0"
        />
    </form>
</div>
