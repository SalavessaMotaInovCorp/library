<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold text-center">
            ADMIN PANEL
        </h2>
    </x-slot>

    <div class="py-12 text-black bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <div class="border border-gray-300 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-3">
                <div class="text-center my-4">
                    <h2 class="text-2xl font-bold text-gray-800">Books</h2>
                </div>

                <div clasS="border shadow-xl p-6 space-y-3 bg-gray-300 rounded-xl">
                    <div class="text-center my-6 px-2">
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h1 class="mb-4">Request Books From The Main Warehouse:</h1>

                            <form method="GET" action="{{ route('googlebooks.search') }}"
                                  class="relative flex items-center justify-center mb-6">
                                <div class="flex flex-col justify-center items-center w-full max-w-lg gap-2">
                                    <input type="text" name="query" placeholder="Search book name..."
                                           class="input input-bordered rounded-md w-full px-4 py-2 text-white">
                                    <x-button type="submit" class="w-full sm:w-auto">🔍 Search</x-button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-gray-300 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-3">
                <div class="text-center my-4">
                    <h2 class="text-2xl font-bold text-gray-800">Orders</h2>
                </div>
                <div clasS="border shadow-xl p-1 space-y-3 bg-gray-300 rounded-xl">
                    <div clasS="border shadow-xl p-6 space-y-3 bg-white rounded-xl">
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <div class="text-center my-1">
                                <x-button href="{{ route('orders.export') }}" class="inline-flex mb-1">Export
                                    Excel
                                </x-button>
                            </div>
                            @livewire('orders-table')
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-gray-300 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-3">
                <div class="text-center my-4">
                    <h2 class="text-2xl font-bold text-gray-800">Book Reviews</h2>
                </div>

                <div clasS="border shadow-xl p-1 space-y-3 bg-gray-300 rounded-xl">

                    <div clasS="border shadow-xl p-6 space-y-3 bg-white rounded-xl">
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            @livewire('book-reviews-table')
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-gray-300 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-3">
                <div class="text-center my-4">
                    <h2 class="text-2xl font-bold text-gray-800">Users</h2>
                </div>
                <div clasS="border shadow-xl p-1 space-y-3 bg-gray-300 rounded-xl">
                    <div class="text-center">
                        <x-button href="/create-admin"
                                  class="p-12 flex flex-col items-center justify-center rounded-lg shadow-xl my-5">
                            <h3 class="text-2xl font-bold">Register a New Admin</h3>
                        </x-button>
                    </div>

                    <div clasS="border shadow-xl p-6 space-y-3 bg-white rounded-xl">
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <div class="text-center my-1">
                                <x-button href="{{ route('admin-panel.export') }}" class="inline-flex mb-1">Export
                                    Excel
                                </x-button>
                            </div>
                            @livewire('users-table')
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-gray-300 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-3">

                <div class="text-center my-4">
                    <h2 class="text-2xl font-bold text-gray-800">Statistics</h2>
                </div>


                <div clasS="border shadow-xl p-6 space-y-3 bg-gray-300 rounded-xl font-bold">


                    <div class="text-center">
                        <div class="p-6 rounded-lg shadow bg-gray-50 mt-6">
                            <h3 class="text-xl font-bold ">{{ $totalUsers }}</h3>
                            <p class="text-gray-600">Registered Users</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
                        <div class="p-6 rounded-lg shadow bg-gray-50">
                            <h3 class="text-xl font-bold ">{{ $totalAdmins }}</h3>
                            <p class="text-gray-600">Administrators</p>
                        </div>
                        <div class="p-6 rounded-lg shadow bg-gray-50">
                            <h3 class="text-xl font-bold ">{{ $totalCitizens }}</h3>
                            <p class="text-gray-600">Citizens</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center my-6">
                        <div class="p-6 rounded-lg shadow bg-gray-50 my-6">
                            <h3 class="text-xl font-bold ">{{ $totalBooks }}</h3>
                            <p class="text-gray-600">Books</p>
                        </div>
                        <div class="p-6 rounded-lg shadow bg-gray-50 my-6">
                            <h3 class="text-xl font-bold ">{{ $totalAuthors }}</h3>
                            <p class="text-gray-600">Authors</p>
                        </div>
                        <div class="p-6 rounded-lg shadow bg-gray-50 my-6">
                            <h3 class="text-xl font-bold ">{{ $totalPublishers }}</h3>
                            <p class="text-gray-600">Publishers</p>
                        </div>
                    </div>


                    <div class="text-center my-6">
                        <div class="p-6 rounded-lg shadow bg-gray-50">
                            <h3 class="text-xl font-bold ">{{ $totalBookRequests }}</h3>
                            <p class="text-gray-600">Book Requests</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <div class="p-6 rounded-lg shadow bg-gray-50">
                            <h3 class="text-xl font-bold ">{{ $totalReturnedRequests }}</h3>
                            <p class="text-gray-600">Returned Requests</p>
                        </div>

                        @if($totalPendingReturnRequests > 0)
                            <div class="p-6 rounded-lg shadow bg-yellow-50">
                                <h3 class="text-xl font-bold ">{{ $totalPendingReturnRequests }}</h3>
                                <p class="text-gray-600">Pending Return Confirmation Requests</p>
                            </div>
                        @else
                            <div class="p-6 rounded-lg shadow bg-green-200">
                                <h3 class="text-xl font-bold ">{{ $totalPendingReturnRequests }}</h3>
                                <p class="text-gray-600">Pending Return Requests</p>
                            </div>
                        @endif


                        <div class="p-6 rounded-lg shadow bg-gray-50">
                            <h3 class="text-xl font-bold ">{{ $totalActiveRequests }}</h3>
                            <p class="text-gray-600">Active Requests</p>
                        </div>
                    </div>

                    <div class="text-center">
                        @if($totalPastDueRequests > 0)
                            <div class="p-6 rounded-lg shadow bg-red-200">
                                <h3 class="text-xl font-bold text-black">{{ $totalPastDueRequests }}</h3>
                                <p class="text-black">Past Due Date Requests</p>
                            </div>
                        @else
                            <div class="p-6 rounded-lg shadow bg-green-200">
                                <h3 class="text-xl font-bold ">{{ $totalPastDueRequests }}</h3>
                                <p class="text-gray-600">Past Due Date Requests</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="flex justify-between">
                <p class="mt-6">
                    <x-button href="{{ url()->previous() }}">Back</x-button>
                </p>

                <p class="mt-6">
                    <x-button href="{{ route('dashboard') }}">Home</x-button>
                </p>
            </div>

        </div>
    </div>

</x-app-layout>


