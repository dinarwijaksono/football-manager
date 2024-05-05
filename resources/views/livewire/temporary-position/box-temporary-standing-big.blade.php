<section class="box">
    <div class="box-header">
        <h2>Klasement Sementara - {{ $division->name }}</h2>

        <p>Musim 2024 </p>
    </div>

    <div class="box-body">

        <table class="w-full" aria-describedby="table-temporary-position">
            <tr class="bg-yellow-500 text-white">
                <th class="border border-slate-500 w-[50px]">NO</th>
                <th class="border border-slate-500 w-auto">Club</th>
                <th class="border border-slate-500 w-[60px]">Play</th>
                <th class="border border-slate-500 w-[60px]">M</th>
                <Th class="border border-slate-500 w-[60px]">S</Th>
                <th class="border border-slate-500 w-[60px]">K</th>
                <th class="border border-slate-500 w-[60px]">GM</th>
                <th class="border border-slate-500 w-[60px]">GK</th>
                <th class="border border-slate-500 w-[60px]">GS</th>
                <th class="border border-slate-500 w-[100px]">Point</th>
            </tr>

            @foreach ($temporaryStanding as $pos)
                <tr @class([
                    'bg-blue-200' => session()->get('club_managed_id') == $pos->club_id,
                ])>
                    <td class="border border-slate-500 p-1 text-center">{{ $loop->iteration }}</td>
                    <td class="border border-slate-500 p-1 ">{{ $pos->club_name }}</td>
                    <td class="border border-slate-500 p-1 text-center ">{{ $pos->number_of_match }}</td>
                    <td class="border border-slate-500 p-1 text-center ">{{ $pos->win }}</td>
                    <td class="border border-slate-500 p-1 text-center ">{{ $pos->draw }}</td>
                    <td class="border border-slate-500 p-1 text-center ">{{ $pos->lost }}</td>
                    <td class="border border-slate-500 p-1 text-center ">{{ $pos->gol_in }}</td>
                    <td class="border border-slate-500 p-1 text-center ">{{ $pos->gol_out }}</td>
                    <td class="border border-slate-500 p-1 text-center ">{{ $pos->gol_difference }}</td>
                    <td class="border border-slate-500 p-1 text-center font-bold text-green-800">{{ $pos->point }}
                    </td>
                </tr>
            @endforeach

        </table>

    </div>
</section>
