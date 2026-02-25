@extends('layouts.main')

@section('container')

<div class="mx-3 container-fluid mb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3 border-bottom header">
        <h3>Manga List</h3>
    </div>

    @include('partials.alert')

    @include('partials.alertError')

    <div class="container-fluid">
        <div class="row justify-content-between mb-3">
            <div class="col-lg-6">
                @can('admin')
                <a href="/manga/create" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-circle"></i> Add Item
                </a>
                @endcan
            </div>
            <div class="col-lg-6">
                <form action="/manga" method="GET" class="row g-3" id="mangaFilterForm">
                    <div class="col-lg-6">
                        <select class="form-select" name="genre" id="selectGenre">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->slug }}" {{ Request::input('genre') == $genre->slug ? 'selected' : '' }}>{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" style="border-color:rgb(0, 0, 0);" placeholder="Search name..." name="search" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="my-2">
            {{ $mangas->links() }}
        </div>
        
        <div class="row" id="mangaList">
            @if($mangas->count())
                @foreach ($mangas as $manga)
                    <div class="col-lg-3 col-md-6 mb-3" data-genre="{{ $manga->genre->slug }}">
                        <div class="card shadow-sm h-100">
                            @if($manga->image)
                                <img src="{{ asset('storage/' . $manga->image) }}" class="card-img-top h-100" style="object-fit: cover;" alt="{{ $manga->name }}">
                            @else
                                <img src="{{ asset('default-cover.png') }}" class="card-img-top h-100" style="object-fit: cover;" alt="{{ $manga->name }}">
                            @endif
                    
                            <div class="card-body">
                                <h5 class="card-title">{{ $manga->name }}</h5>
                                <span class="card-text">Author: {{ $manga->author }}</span><br>
                                <span class="card-text">Year: {{ $manga->published_year ?? '-' }}</span><br>
                                <span class="{{ $manga->stock > 0 ? 'card-text' : 'text-danger'}}">Available Copies: {{ $manga->stock }}</span>
                            </div>
                    
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary mx-2 btn-detail" data-code="{{ $manga->code }}" data-name="{{ $manga->name }}" data-genre="{{ $manga->genre->name }}" data-author="{{ $manga->author }}" data-publisher="{{ $manga->publisher }}" data-published-year="{{ $manga->published_year }}" data-synopsis="{{ $manga->synopsis }}" data-stock="{{ $manga->stock }}">
                                        <i class="bi bi-eye"></i>{{ auth()->user()->role == 'Admin' ? '' : ' Details' }}
                                    </button>

                                    @if(auth()->user()->role == 'Staff')
                                    <button type="button" class="btn btn-warning mx-2" data-stock="{{ $manga->stock }}" data-bs-toggle="modal" data-bs-target="#updateStock{{ $manga->id }}">
                                        <i class="bi bi-plus-circle"></i> Stock
                                    </button>
                                    @endif
                    
                                    @can('admin')
                                    <a href="/manga/{{ encrypt($manga->code) }}/edit" class="btn btn-warning mx-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                    
                                    <form action="/manga/{{ $manga->code }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger mx-2 deleteButton">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                    @endcan

                                    <div class="modal fade" id="updateStock{{ $manga->id }}" tabindex="-1" aria-labelledby="updateStock{{ $manga->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="updateStock{{ $manga->id }}Label">Update Stock</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <form method="POST" action="/manga/update-stock/{{ $manga->id }}">
                                                @csrf
                                                <div class="mb-3">
                                                  <label class="form-label">Stock</label>
                                                  <input type="number" class="form-control" name="stock" value="{{ $manga->stock }}" autofocus required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Stock</button>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                @endforeach
            @else
            <h3 class="text-center">No data.</h3>
            @endif
        </div>
    </div>
</div>
    
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Book Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <span id="detailName"></span></p>
                        <p><strong>Code:</strong> <span id="detailCode"></span></p>
                        <p><strong>Genre:</strong> <span id="detailGenre"></span></p>
                        <p><strong>Author:</strong> <span id="detailAuthor"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Publisher:</strong> <span id="detailPublisher"></span></p>
                        <p><strong>Published Year:</strong> <span id="detailPublishedYear"></span></p>
                        <p><strong>Available Copies:</strong> <span id="detailStock"></span></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Synopsis:</strong> <span id="detailSynopsis"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/profile/change-password/{{ auth()->user()->id }}">
          @csrf
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="currentPassword" name="currentPassword" autofocus required>
              <button class="btn btn-outline-secondary togglePassword" style="border-left: 0px"  type="button">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="newPassword" name="newPassword" required>
              <button class="btn btn-outline-secondary togglePassword" style="border-left: 0px"  type="button">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
              <button class="btn btn-outline-secondary togglePassword" style="border-left: 0px" type="button">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
  
<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            let name = $(this).data('name');
            let code = $(this).data('code');
            let genre = $(this).data('genre');
            let author = $(this).data('author');
            let publisher = $(this).data('publisher');
            let publishedYear = $(this).data('published-year');
            let synopsis = $(this).data('synopsis');
            let stock = $(this).data('stock');

            $('#detailName').text(name);
            $('#detailCode').text(code);
            $('#detailGenre').text(genre);
            $('#detailAuthor').text(author ?? '-');
            $('#detailPublisher').text(publisher ?? '-');
            $('#detailPublishedYear').text(publishedYear ?? '-');
            $('#detailSynopsis').text(synopsis ?? '-');
            $('#detailStock').text(stock);

            $('#detailsModal').modal('show');
        });

        $('#selectGenre').change(function() {
            $('#mangaFilterForm').submit();
        });

        // function filterMangas() {
        //     let genre = $('#selectGenre').val().toLowerCase();
        //     let searchText = $('#search').val().toLowerCase();

        //     $('#mangaList .col-md-4').each(function() {
        //         let mangaGenre = $(this).data('genre').toLowerCase();
        //         let mangaName = $(this).find('.card-title').text().toLowerCase();

        //         if ((genre === '' || mangaGenre === genre) && (searchText === '' || mangaName.includes(searchText))) {
        //             $(this).show(); 
        //         } else {
        //             $(this).hide();
        //         }
        //     });
        // }
    });
</script>

@endsection

