<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookHaven | {{ $title }}</title>
        <link rel="icon" type="image/png" href="{{ asset('logo/favicon.png') }}" />
        <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="{{ asset('/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('/jquery/node_modules/jquery/dist/jquery.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('datatables/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
        <script src="{{ asset('datatables/node_modules/datatables.net/js/dataTables.min.js') }}"></script>
        <script src="{{ asset('datatables/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    </head>

    <body>
        @include('partials.sidebar')
        <div class="container">
            <main>
                @yield('container')
            </main> 
        </div>
            </div>

        <script src="{{ asset('/select2/dist/js/select2.min.js') }}"></script>
        <script>
            $('#logoutButton').click(function(e) {
                e.preventDefault();

                $('#logoutForm').submit();
            });

            function previewImage(){
                const image = document.querySelector('#image');
                const imgPreview = document.querySelector('.img-preview');

                if (image.files.length === 0) {
                    imgPreview.style.display = 'none';
                    return;
                }

                imgPreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent){
                    imgPreview.src = oFREvent.target.result;
                }
            }

            $(document).ready(function() {
                $('.deleteButton').on('click', function(event) {
                    const confirmDelete = confirm('Are you sure you want to delete this data? This action may delete all related data.');
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

        <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
