<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Readashi | {{ $title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/favicon.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.2.2/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.2.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
</head>

<body>
    @include('partials.sidebar')
    <div class="container">
        <main>
            @yield('container')
        </main>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#logoutButton').click(function(e) {
            e.preventDefault();

            $('#logoutForm').submit();
        });

        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
        }

        function previewImage(input) {
            const imageInput = input || document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');
            const fileInfo = document.querySelector('.file-info');
            const initialSrc = imgPreview ? imgPreview.dataset.initialSrc : '';

            if (!imageInput || !imgPreview) return;

            if (!imageInput.files || imageInput.files.length === 0) {
                if (fileInfo) {
                    fileInfo.textContent = 'Belum ada file dipilih.';
                }

                if (initialSrc) {
                    imgPreview.src = initialSrc;
                    imgPreview.style.display = 'block';
                } else {
                    imgPreview.src = '';
                    imgPreview.style.display = 'none';
                }
                return;
            }

            const selectedFile = imageInput.files[0];
            if (fileInfo) {
                fileInfo.textContent = `${selectedFile.name} (${formatFileSize(selectedFile.size)})`;
            }

            const reader = new FileReader();
            reader.readAsDataURL(selectedFile);

            reader.onload = function(event) {
                imgPreview.src = event.target.result;
                imgPreview.style.display = 'block';
            };
        }

        $(document).ready(function() {
            $('.deleteButton').on('click', function(event) {
                const confirmDelete = confirm(
                    'Are you sure you want to delete this data? This action may delete all related data.'
                    );
                if (!confirmDelete) {
                    event.preventDefault();
                }
            });
        });

        $(document).ready(function() {
            $(".myForm").submit(function() {
                $(".submitButton").prop("disabled", true);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
