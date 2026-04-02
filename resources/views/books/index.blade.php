<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Library Catalogue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(auth()->user()->hasAnyRole(['admin', 'librarian']))
                        <div class="mb-4 flex justify-end">
                            <a href="{{ route('books.create') }}" class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">Create New Book</a>
                        </div>
                    @endif

                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ISBN</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Copies</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <!-- XSS Protection ensures safe output -->
                                    <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm">{{ $book->title }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm">{{ $book->author }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm">{{ $book->isbn }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm">
                                        @if($book->copies > 0)
                                            <span class="text-green-600 font-bold">{{ $book->copies }}</span>
                                        @else
                                            <span class="text-red-600 text-xs font-bold">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm flex space-x-2">
                                        
                                        @if(auth()->user()->hasRole('member'))
                                            @if($book->copies > 0)
                                                <form method="POST" action="{{ route('borrows.store', $book) }}">
                                                    @csrf
                                                    <button type="submit" class="text-dark bg-green-500 hover:bg-green-700 px-3 py-1 rounded">Borrow</button>
                                                </form>
                                            @else
                                                <span class="text-xs text-red-500 italic mt-1 relative block">Book Currently Unavailable</span>
                                            @endif
                                        @endif

                                        @if(auth()->user()->hasAnyRole(['admin', 'librarian']))
                                            <a href="{{ route('books.edit', $book) }}" class="text-dark bg-yellow-500 hover:bg-yellow-700 px-3 py-1 rounded">Edit</a>
                                            <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Ensure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-dark bg-red-500 hover:bg-red-700 px-3 py-1 rounded">Delete</button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
