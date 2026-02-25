@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
      <h3>Genre List</h3>
  </div>

  @include('partials.alert')

  @error('name')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror

  @error('slug')
    <div class="alert alert-danger alert-dismissible fade show col" role="alert">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @enderror

  <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addGenreModal">
    <i class="bi bi-plus-circle"></i> Add Genre
  </button>

  @if($genres->count())
    <table class="table table-bordered align-middle text-center" id="genre-table" style="border-color:rgb(194, 194, 194);">
      <thead>
        <tr>
          <th scope="col" class="table-primary align-middle text-center">#</th>
          <th scope="col" class="table-primary align-middle text-center">Name</th>
          <th scope="col" class="table-primary align-middle text-center">Total Items</th>
          <th scope="col" class="table-primary align-middle text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($genres as $genre)
          <tr>
            <td scope="row" class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $genre->name }}</td>
            <td data-order="{{ $genre->mangas->count() }}" class="text-center">
              {{ $genre->mangas->count() }}
            </td>
            <td scope="col" class="d-flex justify-content-center">
              <button href="#" class="btn btn-warning editButton" data-bs-toggle="modal" data-bs-target="#editGenreModal{{ $genre->id }}">
                <i class="bi bi-pencil-square"></i>
              </button>

              <div class="modal fade text-start" id="editGenreModal{{ $genre->id }}" tabindex="-1" aria-labelledby="editGenreModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editGenreModalLabel">Edit Genre</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form class="myForm" id="editGenreForm" method="POST" action="/genre/{{ $genre->slug }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="editName" class="form-label">Name</label>
                          <input type="text" class="form-control editName" id="editName" name="name" value="{{ $genre->name }}" required>
                        </div>
                        <div class="mb-3">
                          <label for="editSlug" class="form-label">Slug</label>
                          <input type="text" class="form-control editSlug" id="editSlug" name="slug" value="{{ $genre->slug }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary submitButton">Update Genre</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <form action="/genre/{{ $genre->slug }}" method="POST">
                @method('delete')
                @csrf
                <button class="btn btn-danger mx-2 deleteButton">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
    </tbody>
  </table>
  @else
  <h3 class="text-center">No data.</h3>
  @endif
</div>

<div class="modal fade" id="addGenreModal" tabindex="-1" aria-labelledby="addGenreModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addGenreModalLabel">Add Genre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="myForm" id="addGenreForm" method="POST" action="/genre">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
          </div>
          <button type="submit" class="btn btn-primary submitButton">Add Genre</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#genre-table').DataTable({
      "columnDefs": [
        { "type": "num", "targets": 2 },
        { "orderable": false, "targets": 3 }
      ]
    });

    $('.editName').on('keyup', function() {
      let preslug = $(this).val();
      preslug = preslug.replace(/ /g, "-");
      $('.editSlug').val(preslug.toLowerCase());
    });

    $('#name').on('keyup', function() {
      let preslug = $(this).val();
      preslug = preslug.replace(/ /g, "-");
      $('#slug').val(preslug.toLowerCase());
    });
  });

  // $('#addGenreForm').submit(function(event) {
  //   event.preventDefault();

  //   $.ajax({
  //     url: $(this).attr('action'),
  //     method: 'POST',
  //     data: $(this).serialize(),
  //     success: function(response) {
  //       $('#addGenreModal').modal('hide');
  //       location.reload();
  //     },
  //     error: function(xhr, status, error) {
  //       console.error(xhr.responseText);
  //     }
  //   });
  // });
</script>
      
@endsection

