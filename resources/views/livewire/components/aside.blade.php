<aside class="bg-slate-600">

    <div class="profile">
        <h3 class="text-white mb-0">{{ session()->get('profile_name') }}</h3>
        <p class="text-[14px] mt-0 text-white">{{ session()->get('club_managed_name') }}</p>
    </div>

    <hr class="my-5 mx-3">

    <ul>
        <a href="/">
            <li @class(['active' => session()->get('page_is_active') == 'dashboard'])>Dashboard</li>
        </a>

        <a href="/competition">
            <li @class([
                'active' => session()->get('page_is_active') == 'compotition',
            ])>Kompetisi</li>
        </a>

        <a href="/timetable">
            <li @class([
                'active' => session()->get('page_is_active') == 'timetable',
            ])>Jadwal</li>
        </a>
    </ul>

    <hr class="my-5 mx-3">

    <ul>
        <li class="btn">
            <button type="button" wire:click="doLogout">Logout</button>
        </li>
    </ul>

</aside>
