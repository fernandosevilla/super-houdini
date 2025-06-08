@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav aria-label="pagination">
            <ul class="flex shrink-0 items-center justify-center gap-2 text-sm font-medium">
                {{-- Enlace “Anterior” --}}
                <li>
                    @if ($paginator->onFirstPage())
                        {{-- Estado “disabled” --}}
                        <span class="flex items-center rounded-md p-1 text-neutral-400 cursor-default dark:text-neutral-600" aria-label="{{ __('pagination.previous') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        {{-- Navegación normal hacia la página anterior --}}
                        @if(method_exists($paginator,'getCursorName'))
                            <button
                                type="button"
                                dusk="previousPage"
                                wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}"
                                wire:click="setPage('{{ $paginator->previousCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                class="flex items-center rounded-md p-1 text-neutral-600 hover:text-black dark:text-neutral-300 dark:hover:text-white"
                                aria-label="{{ __('pagination.previous') }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                                {!! __('pagination.previous') !!}
                            </button>
                        @else
                            <button
                                type="button"
                                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="flex items-center rounded-md p-1 text-neutral-600 hover:text-black dark:text-neutral-300 dark:hover:text-white"
                                aria-label="{{ __('pagination.previous') }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                                {!! __('pagination.previous') !!}
                            </button>
                        @endif
                    @endif
                </li>

                {{-- Enlace “Siguiente” --}}
                <li>
                    @if ($paginator->hasMorePages())
                        @if(method_exists($paginator,'getCursorName'))
                            <button
                                type="button"
                                dusk="nextPage"
                                wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}"
                                wire:click="setPage('{{ $paginator->nextCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                class="flex items-center rounded-md p-1 text-neutral-600 hover:text-black dark:text-neutral-300 dark:hover:text-white"
                                aria-label="{{ __('pagination.next') }}"
                            >
                                {!! __('pagination.next') !!}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <button
                                type="button"
                                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                wire:loading.attr="disabled"
                                dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="flex items-center rounded-md p-1 text-neutral-600 hover:text-black dark:text-neutral-300 dark:hover:text-white"
                                aria-label="{{ __('pagination.next') }}"
                            >
                                {!! __('pagination.next') !!}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    @else
                        {{-- Estado “disabled” --}}
                        <span class="flex items-center rounded-md p-1 text-neutral-400 cursor-default dark:text-neutral-600" aria-label="{{ __('pagination.next') }}">
                            {!! __('pagination.next') !!}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </li>
            </ul>
        </nav>
    @endif
</div>
