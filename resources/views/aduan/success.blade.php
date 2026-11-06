<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan Berhasil</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; padding: 40px;">

    <div style="max-width: 600px; margin: 50px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">

        <h1 style="color: #16a34a; text-align: center;">
            ✓ Aduan Berhasil Dikirim
        </h1>

        <p style="text-align: center; color: #555;">
            Aduan kamu telah berhasil dikirim.
        </p>

        <hr style="margin: 30px 0;">

        <p>
            <strong>Nomor Tiket:</strong>
        </p>

        <h2 style="text-align: center; color: #2563eb;">
            {{ $laporan->ticket_number }}
        </h2>

        <p>
            <strong>Judul:</strong><br>
            {{ $laporan->judul }}
        </p>

        <p>
            <strong>Lokasi:</strong><br>
            {{ $laporan->lokasi }}
        </p>

        <p>
            <strong>Status:</strong><br>
            Menunggu Verifikasi
        </p>

        <div style="text-align: center; margin-top: 30px;">

            <a href="{{ route('aduan.tracking') }}"
               style="display: inline-block; background: #2563eb; color: white; padding: 12px 20px; text-decoration: none; border-radius: 8px;">
                Cek Status Aduan
            </a>

            <br><br>

            <a href="{{ route('aduan.create') }}"
               style="color: #2563eb;">
                Buat Aduan Baru
            </a>

            <br><br>

            <a href="{{ route('home') }}"
               style="color: #666;">
                Kembali ke Beranda
            </a>

        </div>

    </div>

</body>
</html>