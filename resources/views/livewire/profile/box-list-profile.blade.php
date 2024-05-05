<div class="flex justify-center ">
    <div class="basis-4/12 bg-white p-2 my-[100px] shawdown-md">
        <h3 class="text-center mb-5">Muat profile</h3>

        @if (session()->has('deleteSuccess'))
            <div class="p-2 text-[14px] border border-green-500 bg-green-100 mb-2">
                <p>{{ session()->get('deleteSuccess') }}</p>
            </div>
        @endif

        @foreach ($profiles as $key)
            <div class="border border-slate-500 mb-2 p-2">
                <p>Profile : {{ $key->name }}</p>
                <p>Managed club : barcelone</p>

                <div class="flex justify-end mt-2 gap-2">
                    <div class="basis-4/12 ">
                        <button type="button" wire:click="doDeleteProfile({{ $key->id }})"
                            class="bg-red-500 w-full text-white text-[13px] py-1 ">Hapus</button>
                    </div>

                    <div class="basis-4/12">
                        <button type="button" wire:click="doLoadProfile({{ $key->id }})"
                            class="bg-blue-500 w-full text-white text-[14px] py-1 ">Muat</button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex justify-end">
            <div class="basis-4/12">
                <a href="/profile"
                    class="inline-block bg-red-500 text-white hover:bg-red-600 w-full text-center hover:text-white">Kembali</a>
            </div>
        </div>

    </div>
</div>
