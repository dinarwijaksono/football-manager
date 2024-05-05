<section class="mb-[100px]">

    <table class="w-full" aria-describedby="table-club mb-5">
        <tr>
            <th class="border border-slate-500">No</th>
            <th class="border border-slate-500">Negara</th>
            <th class="border border-slate-500">Divisi</th>
            <th class="border border-slate-500">Club</th>
            <th class="border border-slate-500"></th>
        </tr>

        @foreach ($clubs as $key)
            <tr class="hover:bg-slate-200">
                <td class="border border-slate-500 text-center">{{ $loop->iteration }}</td>
                <td class="border text-center border-slate-500 p-1">{{ $key->country }}</td>
                <td class="border border-slate-500 text-center p-1">{{ $key->division_name }}</td>
                <td class="border border-slate-500 p-1">{{ $key->club_name }}</td>
                <td class="border border-slate-500 p-1 w-[100px]">
                    <button wire:click="doSelectClub({{ $key->id }})"
                        class="w-full bg-blue-500 text-[13px] py-1 px-2 rounded-sm text-white hover:bg-blue-400">Pilih</button>
                </td>
            </tr>
        @endforeach

    </table>

    <button type="button" wire:click="doBack"
        class="mt-2 w-full bg-red-500 text-[13px] py-1 px-2 rounded-sm text-white hover:bg-red-400">Kembali ke
        Home</button>

</section>
