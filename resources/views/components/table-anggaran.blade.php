<table>
    <thead>
        <tr>
            <th style="width:50px; text-align:center;">No</th>
            <th><i class="fas fa-list-ol"></i> No Rekening</th>
            <th><i class="fas fa-align-left"></i> Uraian</th>
            <th><i class="fas fa-money-bill-wave"></i> Jumlah Anggaran</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $rowIndex = 0; 
            $no = 1; 
        @endphp

        @foreach ($kegiatanUtamas as $utama)
            @php $rowIndex++; @endphp
            <tr x-show="showAll || {{ $rowIndex }} <= 5" style="background:#f0f8ff;">
                <td style="text-align:center;">{{ $no++ }}</td>
                <td>{{ $utama->rekeningUtama->no_rek ?? '-' }}</td>
                <td><strong>{{ $utama->uraian }}</strong></td>
                <td>
                    @php $total = $utama->jumlahAnggarans->sum('jumlah'); @endphp
                    Rp {{ number_format($total, 0, ',', '.') }}
                </td>
            </tr>

            @foreach ($utama->subKegiatans as $sub)
                @php $rowIndex++; @endphp
                <tr x-show="showAll || {{ $rowIndex }} <= 5">
                    <td style="text-align:center;">{{ $no++ }}</td>
                    <td>{{ $sub->no_rek }}</td>
                    <td style="padding-left:20px;">- {{ $sub->uraian }}</td>
                    <td>
                        Rp {{ number_format($sub->jumlahAnggarans->sum('jumlah'), 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
