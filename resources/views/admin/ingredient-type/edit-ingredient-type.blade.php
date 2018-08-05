@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection



@section('content')
    <section class="add-section">
        <h3 class="admin-panel-title">Edit Ingredient Type</h3>

        <form id="edit_ingredient_form" action="{{route('adminIngredientType.edit')}}" method="post">
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
            <input type="hidden" name="id" class="form-control" value="{{ $ingredientType->id }}">
            <div class="card-block">
                <label>Ingredient Type ID</label>
                <p>{{$ingredientType->id}}</p>
            </div>
            <div class="card-block">
                <label>Ingredient Type Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name', $ingredientType->name)}}">
            </div>
            <div class="card-block">
                <label>Ingredients in Type</label>
                <table class="table table-bordered un-hover">
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Edit</td>
                    </tr>
                    @foreach($ingredientType->recipeIngredients as $ingredient)
                        <tr>
                            <td>{{$ingredient->id}}</td>
                            <td>{{$ingredient->name}}</td>
                            <td> <a href="{{route('adminIngredients.edit', $ingredient->id)}}" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="card-block">
                <button id="submit-btn" type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save
                </button>
            </div>
        </form>

    </section>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2-box').select2();
        });
    </script>
@endsection