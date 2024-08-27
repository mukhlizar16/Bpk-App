<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
</head>

<body>
    <table class="table">
        <thead>
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
        <thead>
            <tr>
                @for ($i = 0; $i < 36; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
        </thead>

        <tbody>
            @php
                $programCounter = 65;
            @endphp
            @foreach ($programs as $program)
                <tr>
                    <td style="font-weight: 800;">{{ chr($programCounter++) }}</td>
                    <td colspan="3" style="font-weight: 800; border: 1px solid">
                        Program: {{ $program->keterangan }}
                    </td>
                    <td colspan="1" style="font-weight: 800; border: 1px solid">
                        {{ $program->kegiatan->sum(function ($kegiatan) {
                            return $kegiatan->Subkegiatan->sum(function ($subkegiatan) {
                                return $subkegiatan->Pagu->sum('jumlah');
                            });
                        }) }}
                    </td>
                    <td colspan="18" style="font-weight: 800; border: 1px solid">
                    </td>
                </tr>
                @php
                    $kegiatanCounter = 1;
                @endphp
                @foreach ($program->kegiatan as $kegiatan)
                    <tr>
                        <td style="font-weight: 800">{{ romanNumerals($kegiatanCounter++) }}</td>
                        <td colspan="3" style="font-weight: 800">Kegiatan: {{ $kegiatan->keterangan }}</td>
                        <td colspan="1" style="font-weight: 800; border: 1px solid">
                            {{ $kegiatan->subkegiatan->flatMap(function ($subkegiatan) {
                                    return $subkegiatan->pagu->pluck('jumlah');
                                })->sum() }}
                        </td>
                        <td colspan="18" style="font-weight: 800; border: 1px solid">
                        </td>
                    </tr>

                    @php
                        $subkegiatanCounter = 1;
                    @endphp
                    @foreach ($kegiatan->subkegiatan as $subkegiatan)
                        <tr>
                            <td style="font-weight: 800">{{ $subkegiatanCounter++ }}</td>
                            <td colspan="3" style="font-weight: 800">Subkegiatan: {{ $subkegiatan->keterangan }}</td>
                            <td colspan="1" style="font-weight: 800; border: 1px solid">
                                {{ $subkegiatan->pagu->sum('jumlah') }}
                            </td>
                            <td colspan="18" style="font-weight: 800; border: 1px solid">
                            </td>
                        </tr>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($subkegiatan->Pagu as $pagu)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td></td>
                                <td>{{ $pagu->paket }}</td>
                                <td>{{ $pagu->SumberDana->keterangan }}</td>
                                <td>{{ $pagu->jumlah }}</td>
                                @if ($pagu->kontrak)
                                    <td>{{ $pagu->kontrak->cara_pengadaan }}</td>
                                    <td>{{ $pagu->kontrak->penyedia }}</td>
                                    <td>{{ $pagu->kontrak->nomor }}</td>
                                    <td>{{ $pagu->kontrak->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $pagu->kontrak->nilai_kontrak }}</td>
                                    <td>{{ $pagu->kontrak->jangka_waktu }}</td>
                                    <td>
                                        @php
                                            $bukti = $pagu->kontrak->bukti == 1 ? 'ya' : 'tidak';
                                        @endphp
                                        {{ $bukti }}
                                    </td>
                                    @if ($pagu->kontrak->sp2d)
                                        @foreach ($pagu->kontrak->sp2d as $sp2d)
                                            <td>{{ $sp2d->nomor }}</td>
                                        @endforeach
                                    @else
                                        <td>-</td>
                                    @endif
                                @else
                                    <td colspan="5">-</td>
                                    <td>-</td>
                                @endif
                                <td>{{ $pagu->bap->first()->nomor ?? '-' }}</td>
                                <td>{{ $pagu->bap->first()->tanggal ?? '-' }}</td>
                                <td>{{ $pagu->bast->first()->nomor ?? '-' }}</td>
                                <td>{{ $pagu->bast->first()->tanggal ?? '-' }}</td>
                                <td>{{ $pagu->bastPho->first()->nomor ?? '-' }}</td>
                                <td>{{ $pagu->bastPho->first()->tanggal ?? '-' }}</td>
                                <td>{{ $pagu->bastPho->first()->ket ?? '-' }}</td>
                                <td>{{ $pagu->realisasiKeuangan->sum('nilai') }}</td>
                                <td>{{ $pagu->realisasiKeuangan->sum('bobot') }}</td>
                                <td>{{ $pagu->realisasiFisik->sum('nilai') }}</td>
                                <td>{{ $pagu->realisasiFisik->sum('bobot') }}</td>
                                <td>
                                    @if ($pagu->Spmk)
                                        {{ $pagu->Spmk->nomor }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($pagu->Spmk)
                                        {{ $pagu->Spmk->tanggal }}
                                    @else
                                        -
                                    @endif
                                </td>
                                @if ($pagu->Kontrak)
                                    @php
                                        $kontraks = $pagu->Kontrak;
                                    @endphp
                                    @if ($kontraks->Adendum)
                                        @foreach ($kontraks->Adendum as $adendum)
                                            <td>{{ $adendum->nomor }}</td>
                                            <td>{{ $adendum->tanggal }}</td>
                                            <td>{{ $adendum->keterangan }}</td>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                                <td></td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="22"></td>
                </tr>
            @endforeach

            @php
                function romanNumerals($number)
                {
                    $romans = [
                        1 => 'I',
                        2 => 'II',
                        3 => 'III',
                        4 => 'IV',
                        5 => 'V',
                        6 => 'VI',
                        7 => 'VII',
                        8 => 'VIII',
                        9 => 'IX',
                        10 => 'X',
                        11 => 'XI',
                        12 => 'XII',
                        13 => 'XIII',
                        14 => 'XIV',
                        15 => 'XV',
                        16 => 'XVI',
                        17 => 'XVII',
                        18 => 'XVIII',
                        19 => 'XIX',
                        20 => 'XX',
                    ];

                    return $romans[$number] ?? $number;
                }
            @endphp

        </tbody>
    </table>


</body>

</html>
