<x-authenticated-layout>
    <x-slot name="head">
        <title>xxx</title>
    </x-slot>

    <section class="xxx">
        <div class="body">
            @if ($xxx->isNotEmpty())
                <div class="table list_items">
                    <div class="header">
                        <div class="details">
                            <p class="title">xxx</p>
                            <p class="stats">
                                <span>{{ $xxx }} {{ Str::plural('xxx', $xxx) }}</span>
                            </p>
                        </div>
    
                        <x-search-input />

                        <div class="btn">
                            <a href="{{ route('xxx.create') }}">New xxx</a>
                        </div>
                    </div>
    
                    <table>
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>xxx</th>
                                <th class="actions center">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($xxx as $xxx)
                                <tr class="searchable">
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td>{{ $xxx->xxx }}</td>
                                    <td class="actions center">
                                        <div class="action_buttons">
                                            <div class="action">
                                                <a href="{{ route('xxx.edit', $xxx->id) }}">
                                                    <span class="fas fa-eye"></span> 
                                                </a> 
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No xxx yet.</p>
                <a href="{{ route('xxx.create') }}">Add New</a>
            @endif
        </div>
    </section>

    <x-slot name="scripts">
        <x-search />
    </x-slot>
</x-authenticated-layout>



<x-authenticated-layout>
    <x-slot name="head">
        <title>xxx | New</title>
    </x-slot>

    <section class="xxx">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('xxx.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>New xxx</p>
            </div>

            <form action="{{ route('xxx.store') }}" method="post">
                @csrf

                <div class="inputs">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="name" value="{{ old('name') }}">
                    <x-input-error field="name" />
                </div>

                <button type="submit">Add xxx</button>
            </form>
        </div>
    </section>
</x-authenticated-layout>



<x-authenticated-layout>
    <x-slot name="head">
        <title>xxx | Update</title>
    </x-slot>

    <section class="xxx">
        <div class="custom_form">
            <div class="header">
                <div class="icon">
                    <a href="{{ route('xxx.index') }}">
                        <span class="fas fa-arrow-left"></span>
                    </a>
                </div>
                <p>Update xxx</p>
            </div>

            <form action="{{ route('xxx.update', $xxx->id) }}" method="post">
                @csrf
                @method('patch')

                xxx_inputs

                <div class="buttons">
                    <button type="submit">Update xxx</button>

                    <button type="button" class="btn_danger" onclick="deleteItem({{ $xxx->id }}, 'xxx');"
                        form="deleteForm_{{ $xxx->id }}">
                        <i class="fas fa-trash-alt delete"></i>
                        <span>Delete xxx</span>                        
                    </button>
                </div>
            </form>

            <form id="deleteForm_{{ $xxx->id }}" action="{{ route('xxx.destroy', $xxx->id) }}" method="post"
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
