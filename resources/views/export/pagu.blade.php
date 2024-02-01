<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            font-weight: bold;
        }

        .header-table {
            font-weight: 600;
        }

        .text-center {
            text-align: center;
        }

        hr {
            border-top: 2px solid #000;
        }
    </style>
</head>

<body style="padding-left: 0px 20px 0px 20px; ">

    <table class="table" style="width: 100%;">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th colspan="2">Jenis dan Uraian Kegiatan Pembangunan dan Pengadaan</th>
                <th colspan="2">Pagu Anggaran</th>
                <th>Cara Pengadaan</th>
                <th colspan="5">Kontrak/SPK/SP</th>
                <th rowspan="2">Bukti Kewajaran harga dari Penyedia (Ada/Tidak)</th>
                <th colspan="2">Surat Perintah Mulai Kerja (SPMK)</th>
                <th colspan="3">Adendum Kontrak I</th>
                <th colspan="3">Adendum Kontrak II</th>
                <th colspan="3">Adendum Kontrak III</th>

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
                @for ($i = 0; $i < 23; $i++)
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
                    <td colspan="3" style="font-weight: 800; border: 1px solid">Program: {{ $program->keterangan }}
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
                            {{ $kegiatan->Subkegiatan->flatMap(function ($subkegiatan) {
                                return $subkegiatan->Pagu->pluck('jumlah');
                            })->sum() }}
                        </td>
                        <td colspan="18" style="font-weight: 800; border: 1px solid">
                        </td>
                    </tr>

                    @php
                        $subkegiatanCounter = 1;
                    @endphp
                    @foreach ($kegiatan->Subkegiatan as $subkegiatan)
                        <tr>
                            <td style="font-weight: 800">{{ $subkegiatanCounter++ }}</td>
                            <td colspan="3" style="font-weight: 800">Subkegiatan: {{ $subkegiatan->keterangan }}</td>
                            <td colspan="1" style="font-weight: 800; border: 1px solid">{{ $subkegiatan->Pagu->sum('jumlah') }}
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
                                @if ($pagu->Kontrak)
                                    <td>{{ $pagu->Kontrak->cara_pengadaan }}</td>
                                    <td>{{ $pagu->Kontrak->penyedia }}</td>
                                    <td>{{ $pagu->Kontrak->nomor }}</td>
                                    <td>{{ $pagu->Kontrak->tanggal }}</td>
                                    <td>{{ $pagu->Kontrak->nilai_kontrak }}</td>
                                    <td>{{ $pagu->Kontrak->jangka_waktu }}</td>
                                    <td>
                                        @php
                                            $bukti = $pagu->kontrak->bukti == 1 ? 'ya' : 'tidak';
                                        @endphp
                                        {{ $bukti }}
                                    </td>
                                @else
                                    <td colspan="5">-</td>
                                    <td>-</td>
                                @endif
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
