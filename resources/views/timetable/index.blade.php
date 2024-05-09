@extends('layout.main-layout')

@section('main-section')
    <section class="box">
        <div class="body-header mb-5">
            <h3>Jadwal Pertandingan</h3>
        </div>

        <div class="box-body">

            @foreach ($timetable as $key)
                <section class="border border-slate-500 py-1 px-2 flex bg-orange-100 mb-2 text-center">
                    <div class="basis-2/12">
                        <a href="">{{ $key->division_name }}</a>
                    </div>

                    <div class="basis-2/12">
                        {{ date('j F Y', $key->date) }}
                    </div>
                    <div class="basis-1/12">
                        {{ $key->home_id == $clubManagedId ? 'Home' : 'Away' }}
                    </div>
                    <div class="basis-4/12">
                        <a href="" @class(['text-green-500' => $key->home_id == $clubManagedId])>{{ $key->home_name }}</a> vs
                        <a href="" @class(['text-green-500' => $key->away_id == $clubManagedId])>{{ $key->away_name }}</a>
                    </div>
                    @if ($key->is_play)
                        <div class="basis-1/12">
                            {{ $key->score_home }} : {{ $key->score_away }}
                        </div>
                        <div class="basis-2/12 ">
                            @if ($key->home_id == $clubManagedId)
                                @if ($key->score_home == $key->score_away)
                                    <span class="text-slate-500">Draw</span>
                                @elseif ($key->score_home > $key->score_away)
                                    <span class="text-green-500">Menang</span>
                                @else
                                    <span class="text-red-500">Kalah</span>
                                @endif
                            @else
                                @if ($key->score_home == $key->score_away)
                                    <span class="text-slate-500">Draw</span>
                                @elseif ($key->score_home < $key->score_away)
                                    <span class="text-green-500">Menang</span>
                                @else
                                    <span class="text-red-500">Kalah</span>
                                @endif
                            @endif
                        </div>
                    @endif
                </section>
            @endforeach

        </div>
    </section>
@endsection
