@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection



@section('content')
    <section class="add-section">
        <h3 class="admin-panel-title">Edit Ingredient Section</h3>

        <form id="edit_ingredient_section_form" action="{{route('adminRecipeIngredientSection.edit')}}" method="post">
            {{ csrf_field() }}
            @if (session('status')=='success')
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
                @endforeach
            @endif
            <input type="hidden" name="id" class="form-control" value="{{ $ingredientSection->id }}">
            <div class="card-block">
                <label>Ingredient Section ID</label>
                <p>{{$ingredientSection->id}}</p>
            </div>
            <div class="card-block">
                <label>Ingredient Section Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name', $ingredientSection->name)}}">
            </div>
            <div class="card-block">
                <button id="submit-btn" type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save
                </button>
            </div>
        </form>

    </section>
@endsection

@section('footer-script')
@endsection