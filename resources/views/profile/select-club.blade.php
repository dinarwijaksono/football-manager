@extends('layout.profile-layout')

@section('main-section')
    <div class="flex justify-center ">
        <div class="basis-6/12 bg-white p-2 mt-[100px] shawdown-md">
            <h3 class="text-center mb-5">Pilih club</h3>

            @livewire('profile.select-club')

        </div>
    </div>
@endSection
