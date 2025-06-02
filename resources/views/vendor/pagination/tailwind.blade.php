@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        {{-- Mobile view --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous Page (Mobile) --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md cursor-default dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- Next Page (Mobile) --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="ml-3 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none transition dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="ml-3 px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md cursor-default dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop view --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="inline-flex shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md cursor-default dark:bg-gray-800 dark:border-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:text-gray-400 focus:outline-none transition dark:bg-gray-800 dark:border-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default dark:bg-gray-800 dark:border-gray-600">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default dark:bg-gray-800 dark:border-gray-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:text-gray-500 focus:outline-none transition dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:text-gray-400 focus:outline-none transition dark:bg-gray-800 dark:border-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span class="px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md cursor-default dark:bg-gray-800 dark:border-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
