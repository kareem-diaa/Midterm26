<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Borrowed Books') }}
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
                    
                    @if($borrows->isEmpty())
                        <p class="text-gray-500 text-center">You have not borrowed any books yet.</p>
                    @else
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Book Title</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Borrowed At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrows as $borrow)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm">{{ $borrow->book->title }}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm">{{ $borrow->book->author }}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-dark text-sm">{{ $borrow->created_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
