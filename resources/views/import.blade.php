@extends("layouts.import-header")

@section("content")
	<h1>Import file</h1>
    <div class="container">
        <h2 class="text-center">
            Laravel Excel/CSV Import
        </h2>

        @if ( Session::has('success') )
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

        @if ( Session::has('error') )
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>{{ Session::get('error') }}</strong>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            Choose your csv File : <input type="file" name="file" class="form-control">
			<div class="form-row text-center">
				<div class="col-12">
					<input type="submit" class="btn btn-primary btn-lg" value="Импортировать">
				</div>
			</div>
        </form>

    </div>
@endsection
