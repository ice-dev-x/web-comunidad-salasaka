@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de paginación" class="flex justify-center mt-6">
        <div class="flex flex-wrap items-center justify-center gap-2">

            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 transition dark:bg-blue-500 dark:hover:bg-blue-600">
                    Anterior
                </a>
            @endif

            {{-- Números de páginas --}}
            @foreach ($elements as $element)
                {{-- Si es separador (por ejemplo "...") --}}
                @if (is_string($element))
                    <span class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">{{ $element }}</span>
                @endif

                {{-- Números de página --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 text-sm font-bold text-white bg-blue-700 rounded-md dark:bg-blue-600">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-4 py-2 text-sm text-blue-600 bg-white border border-blue-300 rounded-md hover:bg-blue-50 transition dark:bg-gray-800 dark:text-blue-400 dark:border-blue-500 dark:hover:bg-gray-700">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 transition dark:bg-blue-500 dark:hover:bg-blue-600">
                    Siguiente
                </a>
            @else
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                    Siguiente
                </span>
            @endif

        </div>
    </nav>
@endif
