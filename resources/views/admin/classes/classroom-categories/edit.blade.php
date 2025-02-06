<x-authenticated-layout>
    <x-slot name="head">
        <title>Classroom Category | Edit</title>
    </x-slot>

    <section class="Classrooms">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('classrooms.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update Classroom Category</p>
            </div>

            <form action="{{ route('classroom-categories.update', $classroom_category->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="input_group_3">
                    <div class="inputs">
                        <label for="name">Classroom Category Name</label>
                        <input type="text" name="name" id="name" placeholder="1 South" value="{{ old('name', $classroom_category->name) }}">
                        <x-input-error field="name" />
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit">Update Category</button>
                    
                    <button type="button" class="btn_danger" onclick="deleteItem({{ $classroom_category->id }}, 'category and its classrooms');"
                        form="deleteForm_{{ $classroom_category->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete Category and classrooms</span>
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $classroom_category->id }}" action="{{ route('classroom-categories.destroy', $classroom_category->id) }}" method="post"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <x-slot name="scripts">
        <x-sweetalert />
    </x-slot>
</x-authenticated-layout>