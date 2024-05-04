@extends('layout.profile-layout')

@section('main-section')
    <div class="flex justify-center ">
        <div class="basis-4/12 bg-white p-2 mt-[100px] shawdown-md">
            <h3 class="text-center mb-5">Football Manager Game</h3>

            <a href="load-profile"
                class="w-full bg-blue-500 inline-block hover:text-white hover:bg-blue-600 hover:underline text-center text-white px-2 py-1 mb-2">Load
                profile</a>

            <a href="/create-profile"
                class="w-full bg-blue-500 inline-block hover:text-white hover:bg-blue-600 hover:underline text-center text-white px-2 py-1 mb-2">Buat
                Profile Baru</a>

        </div>
    </div>
@endSection
