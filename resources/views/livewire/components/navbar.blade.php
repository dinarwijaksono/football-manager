<nav>
    <div class="flex">
        <div class="basis-2/12">
            <h3 class="text-white"><b>Football</b> manager</h3>
        </div>

        <div class="basis-10/12">
            <ul>

                <li class="font-bold text-[16px]">{{ date('J F Y', $date->date) }}</li>

                <li class="btn">
                    <button class="bg-blue-600 text-[17px] hover:bg-blue-800 px-5">Next day</button>
                </li>

            </ul>
        </div>
    </div>

</nav>
