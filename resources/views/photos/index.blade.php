    @extends('layouts.app')

    @section('content')
    <div class="container">
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <h3 class="text-center mb-1 mt-2">Upload Photos</h3>

        <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="photo">Upload Photo</label>
                <input type="file" name="photo" id="photo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="caption">Caption</label>
                <input type="text" name="caption" id="caption" class="form-control" placeholder="Enter caption">
            </div>

            <div class="form-group">
                <label for="privacy">Privacy</label>
                <select name="privacy" id="privacy" class="form-control">
                    <option value="all">Publish for All</option>
                    <option value="friends">Publish Only for Friends</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Upload Photo</button>
        </form>

        <hr>

        <h3 class="text-center mb-4">Your Photos</h3>
        <!-- Display Photos -->
        <div class="row mt-4">
            @foreach($photos as $photo)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('storage/' . $photo->file_path) }}" class="card-img-top" alt="Photo">
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo->user->name }}</h5>
                            <p class="card-text">{{ $photo->caption }}</p>
                            <small class="text-muted">{{ $photo->created_at->diffForHumans() }}</small>
                            <div class="mt-2">
                                <strong>Privacy: </strong>
                                {{ $photo->privacy == 'all' ? 'Public' : 'Friends Only' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endsection