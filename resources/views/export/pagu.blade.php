<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
    <style>
        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        thead.v-center tr th {
            vertical-align: middle
        }

        tr.fw-bold td {
            font-weight: bold;
        }

        th,
        td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <table class="table">
        <thead class="v-center">
            <tr>
                <th rowspan="2">No</th>
                <th colspan="2">Jenis dan Uraian Kegiatan Pembangunan dan Pengadaan</th>
                <th colspan="2">Pagu Anggaran</th>
                <th>Cara Pengadaan</th>
                <th colspan="5">Kontrak/SPK/SP</th>
                <th rowspan="2">Bukti Kewajaran harga dari Penyedia (Ada/Tidak)</th>
                <th rowspan="2">Nomor Sp2d</th>
                <th colspan="2">Berita Acara Pemeriksaan Hasil Pekerjaan (Progress 100%)</th>
                <th colspan="2">Berita Acara Serah Terima (BAST Barang)</th>
                <th colspan="3">Berita Acara Serah Terima Provisional Hand Over (BAST PHO)</th>
                <th colspan="4">Nilai Realisasi</th>
                <th colspan="2">Surat Perintah Mulai Kerja (SPMK)</th>
                <th colspan="3">Adendum Kontrak I</th>
                <th colspan="3">Adendum Kontrak II</th>
                <th colspan="3">Adendum Kontrak III</th>
                <th rowspan="2">Penjab</th>
            </tr>
            <tr>
                <th>Nama Program/ Kegiatan</th>
                <th>Fisik Konstruksi/Nama Barang</th>
                <th>Sumber Dana</th>
                <th>DPA-OPD (Rp)</th>
                <th>Swakelola/ Pengadaan Langsung/ Lelang/ Penunjukan Langsung</th>
                <th>Nama Penyedia</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Nilai (Rp)</th>
                <th>Waktu Pelaksanaan (Hari)</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Ket.</th>
                <th>Kuangan Nilai (Rp)</th>
                <th>Keuangan Bobot (%)</th>
                <th>Fisik Nilai (Rp)</th>
                <th>Fisik Bobot (%)</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Keterangan CCO atau Perpanjangan Waktu</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Keterangan CCO atau Perpanjangan Waktu</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Keterangan CCO atau Perpanjangan Waktu</th>
            </tr>
        </thead>
        <thead class="v-center">
            <tr>
                @for ($i = 0; $i < 36; $i++)
                    <th class="text-center" style="font-size: 10pt">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($programs as $program)
                <tr class="fw-bold">
                    <td class="text-center">{{ abjad($loop->iteration) }}</td>
                    <td colspan="3">Program: {{ $program->keterangan }}</td>
                    <td class="text-end">
                        {{ $program->kegiatans->sum(function ($kegiatan) {
                            return $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                return $subkegiatan->pagus->sum('jumlah');
                            });
                        }) }}
                    </td>
                    <td colspan="4"></td>
                    <td class="text-end">
                        @php
                            $kontrak = 0;
                        @endphp
                        @if ($program->kegiatans->isNotEmpty())
                            @php
                                $kontrak = $program->kegiatans->sum(function ($kegiatan) {
                                    return $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                        return $subkegiatan->pagus->sum(function ($pagu) {
                                            return optional($pagu->kontrak)->jumlah ?? 0;
                                        });
                                    });
                                });
                            @endphp
                            {{ $kontrak }}
                        @else
                            0
                        @endif
                    </td>
                    <td colspan="10"></td>
                    <td class="text-end">
                        @php
                            $realisasi = 0;
                        @endphp
                        @if ($program->kegiatans->isNotEmpty())
                            @php
                                $realisasi = $program->kegiatans->sum(function ($kegiatan) {
                                    return $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                        return $subkegiatan->pagus->sum(function ($pagu) {
                                            return optional($pagu->realisasiKeuangan)->sum('jumlah') ?? 0;
                                        });
                                    });
                                });
                            @endphp
                            {{ $realisasi }}
                        @else
                            0
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $realisasi != 0 ? ($realisasi / $kontrak) * 100 : 0 }}
                    </td>
                    <td class="text-end">
                        @if ($program->kegiatans->isNotEmpty())
                            @php
                                $fisik = $program->kegiatans->sum(function ($kegiatan) {
                                    return $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                        return $subkegiatan->pagus->sum(function ($pagu) {
                                            return optional($pagu->realisasiFisik)->sum('jumlah') ?? 0;
                                        });
                                    });
                                });
                            @endphp
                            {{ $fisik }}
                        @else
                            0
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $fisik != 0 ? ($fisik / $kontrak) * 100 : 0 }}
                    </td>
                    <td colspan="12"></td>
                </tr>
                @foreach ($program->kegiatans as $kegiatan)
                    <tr class="fw-bold">
                        <td class="text-center">{{ romawi($loop->iteration) }}</td>
                        <td colspan="3">
                            Kegiatan: {{ $kegiatan->keterangan }}
                        </td>
                        <td class="text-end">
                            {{ $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                return $subkegiatan->pagus->sum('jumlah');
                            }) }}
                        </td>
                        <td colspan="4"></td>
                        <td class="text-end">
                            @php
                                $kontrak = 0;
                            @endphp
                            @if ($kegiatan->subkegiatans->isNotEmpty())
                                @php
                                    $kontrak = $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                        return $subkegiatan->pagus->sum(function ($pagu) {
                                            return optional($pagu->kontrak)->jumlah ?? 0;
                                        });
                                    });
                                @endphp
                                {{ $kontrak }}
                            @else
                                0
                            @endif
                        </td>
                        <td colspan="10"></td>
                        <td class="text-end">
                            @php
                                $realisasi = 0;
                            @endphp
                            @if ($kegiatan->subkegiatans->isNotEmpty())
                                @php
                                    $realisasi = $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                        return $subkegiatan->pagus->sum(function ($pagu) {
                                            return optional($pagu->realisasiKeuangan)->sum('jumlah') ?? 0;
                                        });
                                    });
                                @endphp
                                {{ $realisasi }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $realisasi != 0 ? ($realisasi / $kontrak) * 100 : 0 }}
                        </td>
                        <td class="text-end">
                            @if ($kegiatan->subkegiatans->isNotEmpty())
                                @php
                                    $fisik = $kegiatan->subkegiatans->sum(function ($subkegiatan) {
                                        return $subkegiatan->pagus->sum(function ($pagu) {
                                            return optional($pagu->realisasiFisik)->sum('jumlah') ?? 0;
                                        });
                                    });
                                @endphp
                                {{ $fisik }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $fisik != 0 ? ($fisik / $kontrak) * 100 : 0 }}
                        </td>
                        <td colspan="12"></td>
                    </tr>
                    @foreach ($kegiatan->subkegiatans as $subkegiatan)
                        <tr class="fw-bold">
                            <td class="text-center">{{ abjadKecil($loop->iteration) }}</td>
                            <td colspan="3">
                                Subkegiatan: {{ $subkegiatan->keterangan }}
                            </td>
                            <td class="text-end">
                                {{ $subkegiatan->pagus->sum('jumlah') }}
                            </td>
                            <td colspan="4"></td>
                            <td class="text-end">
                                @php
                                    $kontrak = $subkegiatan->pagus->sum(function ($pagu) {
                                        return optional($pagu->kontrak)->jumlah ?? 0;
                                    });
                                @endphp
                                {{ $kontrak }}
                            </td>
                            <td colspan="10"></td>
                            <td class="text-end">
                                @php
                                    $realisasi = $subkegiatan->pagus->sum(function ($pagu) {
                                        return optional($pagu->realisasiKeuangan)->sum('jumlah') ?? 0;
                                    });
                                @endphp
                                {{ $realisasi }}
                            </td>
                            <td class="text-center">
                                {{ $realisasi != 0 ? ($realisasi / $kontrak) * 100 : 0 }}
                            </td>
                            <td class="text-end">
                                @php
                                    $fisik = $subkegiatan->pagus->sum(function ($pagu) {
                                        return optional($pagu->realisasiFisik)->sum('jumlah') ?? 0;
                                    });
                                @endphp
                                {{ $fisik }}
                            </td>
                            <td class="text-center">
                                {{ $fisik != 0 ? ($fisik / $kontrak) * 100 : 0 }}
                            </td>
                            <td colspan="12"></td>
                        </tr>
                        @foreach ($subkegiatan->pagus as $pagu)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td></td>
                                <td>{{ $pagu->paket }}</td>
                                <td class="text-center">{{ $pagu->sumberDana->keterangan }}</td>
                                <td class="text-end">{{ $pagu->jumlah }}</td>
                                <td>{{ $pagu->kontrak?->jenisPengadaan->keterangan }}</td>
                                <td>{{ $pagu->kontrak?->penyedia }}</td>
                                <td>{{ $pagu->kontrak?->nomor }}</td>
                                <td class="text-center">{{ $pagu->kontrak?->tanggal->format('d/m/Y') }}</td>
                                <td class="text-end">{{ $pagu->kontrak?->jumlah }}</td>
                                <td class="text-center">{{ $pagu->kontrak?->jangka_waktu }}</td>
                                <td class="text-center">
                                    {{ $pagu->kontrak?->bukti == 1 ? 'Ya' : 'Bukti' }}
                                </td>
                                <td>
                                    {{ $pagu->sp2d ? $pagu->sp2d->nomor : '-' }}
                                </td>
                                <td>
                                    {{ $pagu->bap ? $pagu->bap?->nomor : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $pagu->bap ? $pagu->bap?->tanggal->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    {{ $pagu->bast ? $pagu->bast?->nomor : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $pagu->bast ? $pagu->bast?->tanggal->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    {{ $pagu->bastPho ? $pagu->bastPho?->nomor : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $pagu->bastPho ? $pagu->bastPho?->tanggal->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    {{ $pagu->bastPho ? $pagu->bastPho?->keterangan : '-' }}
                                </td>
                                <td class="text-end">
                                    {{ $pagu->realisasiKeuangan ? $pagu->realisasiKeuangan?->sum('nilai') : 0 }}
                                </td>
                                <td class="text-center">
                                    {{ $pagu->realisasiKeuangan ? $pagu->realisasiKeuangan?->sum('bobot') : 0 }}
                                </td>
                                <td class="text-end">
                                    {{ $pagu->realisasiFisik ? $pagu->realisasiFisik?->sum('nilai') : 0 }}
                                </td>
                                <td class="text-center">
                                    {{ $pagu->realisasiFisik ? $pagu->realisasiFisik?->sum('bobot') : 0 }}
                                </td>
                                <td>
                                    {{ $pagu->smpk ? $pagu->smpk?->nomor : '-' }}
                                </td>
                                <td>
                                    {{ $pagu->smpk ? $pagu->smpk?->tanggal->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach

        </tbody>
    </table>


</body>

</html>
