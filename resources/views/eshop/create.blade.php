@extends('layout.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <button type="submit">New</button>

        </div>
    </div>
@endsection
