<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Laporan</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            padding: 25px 35px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 15px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2 i {
            color: #3498db;
        }

        .alert-success {
            background: #e7f9ed;
            color: #2d7a36;
            border: 1px solid #bde5c8;
            padding: 12px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success i {
            color: #28a745;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }

        th {
            background: #3498db;
            color: #fff;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background: #f9fbfd;
        }

        tr:hover {
            background: #ecf5ff;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s ease;
        }

        .btn i {
            font-size: 15px;
        }

        .btn-danger {
            background: #e3342f;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-secondary {
            background: transparent; 
            color: #136d26; 
            border: none; 
            margin-top: 15px;
            transition: 0.2s ease;
        }

        .btn-secondary i,
        .btn-secondary span {
            pointer-events: none; 
        }

        .btn-secondary:hover {
            background: #6c757d;
            color: #fff; 
        }


        @media(max-width:768px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            td {
                padding: 12px;
                border-bottom: 1px solid #eee;
            }

            td::before {
                font-weight: bold;
                display: block;
                margin-bottom: 5px;
                color: #555;
            }

            td:nth-of-type(1)::before {
                content: "No Rekening";
            }

            td:nth-of-type(2)::before {
                content: "Uraian";
            }

            td:nth-of-type(3)::before {
                content: "Jumlah Anggaran";
            }
        }
    </style>
</head>

<body>
    <div class="container" x-data="{ showAll: false, showModal: false }">

        @if (session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="margin:0;">
                <i class="fas fa-table"></i> Data Anggaran
            </h2>

            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                <i class="fas fa-trash-alt"></i> Hapus Data
            </button>
        </div>

        @include('components.table-anggaran')

        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-secondary" @click="showAll = !showAll">
                <i :class="showAll ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                <span x-text="showAll ? 'Tampilkan Lebih Sedikit' : 'Tampilkan Semua'"></span>
            </button>
        </div>

        @include('components.confirm-delete')
    </div>

    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex align-items-center" style="background-color:#3498db; color:white;">

                <i class="fas fa-edit me-2"></i>
                <h5 class="mb-0">Form Input Laporan</h5>
            </div>
            <div class="card-body">
                @include('components.form-laporan')
            </div>
        </div>
    </div>

</body>

</html>