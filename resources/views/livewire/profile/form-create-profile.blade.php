<div class="basis-4/12 bg-white p-2 mt-[100px] shawdown-md">
    <h3 class="text-center mb-5">Buat Profile Baru</h3>

    @if (session()->has('create-profile-success'))
        <div class="mb-2 bg-green-100 p-2 border border-green-500 text-[14px]">
            <p>{{ session()->get('create-profile-success') }}</p>
        </div>
    @endif

    <div class="mb-2">
        <label for="name">Nama</label>
        <input type="text" class="w-full px-2 py-1 border border-slate-500 outline-none" wire:model="name" id="name"
            placeholder="name">
        @error('name')
            <p class="italic text-red-500 text-[14px]">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-2">
        <div class="basis-4/12">
            <a href="/profile"
                class="w-full inline-block text-center bg-red-500 hover:text-white hover:underline hover:bg-red-600 text-white px-2 py-1">Batal</a>
        </div>

        <div class="basis-4/12">
            <button type="button" wire:click="doCreateProfile"
                class="w-full bg-blue-500 text-white px-2 py-1 hover:underline hover:bg-blue-600">Buat</button>
        </div>
    </div>

</div>
