@extends('dashboard.layouts.main')

@section('content')
<div class="container mx-auto py-10">
    <div class="flex justify-center">
        <div class="bg-white p-8 rounded-3xl shadow-xl w-full md:w-3/4 lg:w-2/3 xl:w-1/2">
            <form id="updateProfileForm" action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Avatar Section -->
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <img 
                            id="avatarImage"
                            src="{{ !empty(session('user')['avatar']) ? session('user')['avatar'] : asset('vertical/assets/images/avatars/11.png') }}" 
                            alt="Avatar" 
                            class="w-32 h-32 rounded-full object-cover shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out"
                        >
                        <label for="avatar" class="absolute bottom-0 right-0 mb-2 mr-2 p-2 bg-blue-500 text-white rounded-full cursor-pointer shadow-md hover:shadow-lg transition duration-300">
                            <i class="material-icons">edit</i>
                        </label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-lg font-semibold">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', session('user')['name']) }}" 
                        class="w-full px-6 py-3 border border-gray-300 rounded-xl mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="username" class="block text-gray-700 text-lg font-semibold">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username', session('user')['username']) }}" 
                        class="w-full px-6 py-3 border border-gray-300 rounded-xl mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    >
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Section -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-lg font-semibold">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', session('user')['email']) }}" 
                        class="w-full px-6 py-3 border border-gray-300 rounded-xl mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Update Button -->
                <div class="mt-6 text-center">
                    <button 
                        type="submit" 
                        class="w-full bg-blue-500 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-600 transition duration-300 transform hover:scale-105"
                    >
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK'
        });
    @endif
</script>

@endsection
@endsection
