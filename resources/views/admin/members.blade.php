<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Members List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg mb-6 border">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Register New Librarian (Admin Only)</h3>
                        <form method="POST" action="{{ route('admin.storeLibrarian') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <input type="text" name="name" placeholder="Name" class="w-full rounded border-gray-300" value="{{ old('name') }}" required>
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <input type="email" name="email" placeholder="Email" class="w-full rounded border-gray-300" value="{{ old('email') }}" required>
                                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <input type="password" name="password" placeholder="Password" class="w-full rounded border-gray-300" required>
                                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full rounded border-gray-300" required>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Create Librarian</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Registered Member Directory</h3>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $member->name }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $member->email }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $member->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
