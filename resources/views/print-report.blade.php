<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Pengaduan</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="mt-9 text-black">
        <div class="flex justify-between w-3/4 mx-auto">
            <img 
                src="/assets/logo-batang.png" 
                alt="Logo Kab Batang"
                class="w-20"
            >
            <div class="text-center">
                <h1 class="font-bold">PEMERINTAH KABUPATEN BATANG</h1>
                <h1 class="font-bold">DINAS PARIWISATA KEPEMUDAAN DAN OLAHRAGA</h1>
                <p>Jl. RA Kartini No.1, Bogoran, Kauman, Kec. Batang, Kabupaten Batang, Jawa Tengah 51216</p>
            </div>
        </div>

        <hr class="w-3/4 border-2 my-3 mx-auto">

        {{-- <h1 class="text-2xl font-bold md:p-5 text-center">Semua Pengaduan</h1> --}}
        <div class="flex flex-row justify-between mt-5 px-20">
            <p class="mb-1">Dicetak pada : {{ $datetimeNow }}</p>
            <form id="filter-report" action="{{ route('filter.report') }}" method="post">
                @csrf
                <div>
                    <select name="month" id="month" class="p-1 min-w-24 border rounded">
                        <option value="" disabled selected hidden>Bulan</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <select name="year" id="year" class="p-1 min-w-24 border rounded">
                        <option value="" disabled selected hidden>Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                    <select name="status" id="status" class="p-1 min-w-24 border rounded">
                        <option value="" disabled selected hidden>Status</option>
                        <option value="proses">Proses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <button type="submit" class="bg-green-light text-white-light font-semibold px-3 py-1 rounded-md">Cetak</button>
                </div>
            </form>
        </div>

        @isset($message)
            <p class="pl-20 font-semibold">{{ $message }}</p>
        @endisset

        <div class="flex flex-col justify-center items-center">

            @forelse ($complaints as $complaint)
                <div class="w-4/5 rounded-md border border-gray m-3 p-5 md:p-7">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="md:order-1">
                            <h3 class="font-semibold text-lg">{{ censorName($complaint->user->name) }}</h3>
                            <h6 class="text-xs">{{ $complaint->date_of_complaint }}</h6>
                            <h5 class="font-semibold md:whitespace-nowrap">Lokasi : {{ $complaint->spot?->name }}</h5>
                            <h5 class="font-semibold md:whitespace-nowrap">Kategori : {{ $complaint->category->name }}</h5>
                            <h5 class="font-semibold pr-2 {{ $complaint->status == 'proses' ? 'text-yellow-light' : 'text-green-light'}}">Status : {{ $complaint->status }}</h5>
                        </div>
                    </div>
                    
                    @if ($complaint->image)
                        <div class="flex justify-center items-center">
                            <img 
                                src="{{ asset('complaints/'.$complaint->image) }}" 
                                alt="{{ $complaint->image }}"
                                class="w-1/2 h-1/2 my-1"
                            >
                        </div>
                    @endif
                    
                    <p>{{ $complaint->content }}</p>
                    <hr class="mt-1.5 mb-1 border border-gray">
                    @foreach ($complaint->responses()->get() as $response)
                        <div class="pl-7">
                            <h4 class="font-semibold">{{ $response->user->role === 'admin' ? $response->user->name : censorName($response->user->name) }}</h4>
                            <p>{{ $response->content }}</p>
                        </div>
                    @endforeach
                </div>
            @empty
                <p class="text-center mt-5">
                    Belum ada laporan.
                </p>
            @endforelse
        </div>

    </div>

    <script>
        window.onload = function(){
            window.print();
        }

        window.onafterprint = function(){
            window.close();
        }

        window.onbeforeunload = function(){
            window.close();
        }
    </script>
</body>
</html>