@extends('layouts.admin')

@section('title', 'Create Category - NotesHub Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Category</h2>
        
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" required 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="flex space-x-6">
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                        <input type="color" name="color" id="color" value="#4361ee"
                               class="mt-1 block w-20 h-10 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex-1">
                        <label for="icon" class="block text-sm font-medium text-gray-700">Icon Class</label>
                        <input type="text" name="icon" id="icon" value="fas fa-folder"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active Category</label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Create Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection