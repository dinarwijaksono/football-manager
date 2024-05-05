<aside class="bg-slate-600">

    <div class="profile">
        <h3 class="text-white mb-0">{{ session()->get('profile_name') }}</h3>
        <p class="text-[14px] mt-0 text-white">Lorem, ipsum.</p>
    </div>

    <hr class="my-5 mx-3">

    <ul>
        <a href="/">
            <li @class(['active' => session()->get('page_is_active') == 'dashboard'])>Dashboard</li>
        </a>

        <a href="/">
            <li>Heading</li>
        </a>

        <a href="/">
            <li>Colors</li>
        </a>
    </ul>

    <hr class="my-5 mx-3">

    <ul>
        <li class="btn">
            <button type="button" wire:click="doLogout">Logout</button>
        </li>
    </ul>

</aside>
