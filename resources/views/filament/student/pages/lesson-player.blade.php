<x-filament-panels::page>
    <div class="w-full space-y-6">

        {{-- HEADER --}}
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <p class="text-sm font-semibold text-amber-500">
                {{ $lesson->module?->title }}
            </p>

            <div class="mt-2 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">
                        {{ $lesson->title }}
                    </h1>

                    @if($lesson->description)
                        <p class="mt-2 max-w-3xl text-sm text-gray-500 dark:text-gray-400">
                            {{ $lesson->description }}
                        </p>
                    @endif
                </div>

                @if($lessonProgress)
                    <div class="grid grid-cols-2 gap-2 text-sm md:grid-cols-4 lg:min-w-[520px]">
                        <div class="rounded-xl bg-amber-950 p-3 text-amber-100 ring-1 ring-amber-800">
                            <p class="text-xs text-amber-300">Estado</p>
                            <p class="font-bold">{{ $lessonProgress->status }}</p>
                        </div>

                        <div class="rounded-xl bg-amber-950 p-3 text-amber-100 ring-1 ring-amber-800">
                            <p class="text-xs text-amber-300">Score</p>
                            <p class="font-bold">{{ $lessonProgress->score }}</p>
                        </div>

                        <div class="rounded-xl bg-amber-950 p-3 text-amber-100 ring-1 ring-amber-800">
                            <p class="text-xs text-amber-300">Intentos</p>
                            <p class="font-bold">{{ $lessonProgress->attempts }}</p>
                        </div>

                        <div class="rounded-xl bg-amber-950 p-3 text-amber-100 ring-1 ring-amber-800">
                            <p class="text-xs text-amber-300">Última actividad</p>
                            <p class="font-bold">
                                {{ $lessonProgress->last_activity_at?->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="rounded-xl bg-amber-950 p-4 text-sm text-amber-100 ring-1 ring-amber-800 lg:min-w-[380px]">
                        <p class="font-semibold">Empezá esta lesson</p>
                        <p class="mt-1 text-amber-200">
                            Leé el contenido y respondé el ejercicio.
                        </p>
                    </div>
                @endif
            </div>
        </section>

        {{-- MAIN LEARNING LAYOUT --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_1fr]">

            {{-- LEFT: CONTENT --}}
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">
                        Contenido
                    </h2>

                    <span class="text-xs text-gray-400">
                        {{ $lesson->contentBlocks->count() }} bloques
                    </span>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    @forelse($lesson->contentBlocks as $block)
                        <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                            @if($block->title)
                                <h3 class="mb-3 text-base font-semibold">
                                    {{ $block->title }}
                                </h3>
                            @endif

                            <div class="prose prose-sm max-w-none leading-relaxed dark:prose-invert">
                                {!! is_array($block->content)
                                    ? ($block->content['html'] ?? json_encode($block->content))
                                    : $block->content !!}
                            </div>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-300 p-6 text-center dark:border-white/10 lg:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Esta lesson todavía no tiene contenido.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- RIGHT: EXERCISE --}}
            <aside >
                <section class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold">
                            Ejercicio
                        </h2>

                        <span class="text-xs text-gray-400">
                            {{ $lesson->exercises->count() }} disponibles
                        </span>
                    </div>

                    @forelse($lesson->exercises as $exercise)
                        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                            <p class="text-xs font-semibold uppercase tracking-wide text-amber-500">
                                {{ $exercise->type }} · {{ $exercise->difficulty }}
                            </p>

                            <h3 class="mt-2 text-xl font-bold">
                                {{ $exercise->title }}
                            </h3>

                            <p class="mt-4 text-base text-gray-700 dark:text-gray-300">
                                {{ $exercise->question }}
                            </p>

                            @if(in_array($exercise->type, [
                                'sentence_transformation',
                                'writing',
                                'open_question',
                            ]))
                                <div class="mt-5">
                                  <textarea
                                      wire:model="selectedAnswers.{{ $exercise->id }}"
                                      rows="6"
                                      placeholder="Escribí tu respuesta..."
                                      class="w-full min-h-[180px] rounded-xl border border-gray-300
                                       bg-gray-50 p-4 text-base text-gray-900 shadow-sm
                                       outline-none transition
                                       focus:border-amber-500
                                       focus:ring-2 focus:ring-amber-500/40
                                       dark:border-white/10
                                       dark:bg-black/20
                                       dark:text-white"
                                  ></textarea>
                                </div>
                            @endif

                            @if(is_array($exercise->options) && count($exercise->options))
                                <div class="mt-5 space-y-3">
                                    @foreach($exercise->options as $option)
                                        @php
                                            $optionValue = is_array($option)
                                                ? ($option['value'] ?? $option['label'] ?? json_encode($option))
                                                : $option;

                                            $optionLabel = is_array($option)
                                                ? ($option['label'] ?? $option['value'] ?? json_encode($option))
                                                : $option;
                                        @endphp

                                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm transition hover:border-amber-400 hover:bg-amber-50 dark:border-white/10 dark:bg-black/20 dark:hover:bg-amber-950/40">
                                            <input
                                                type="radio"
                                                name="exercise_{{ $exercise->id }}"
                                                value="{{ $optionValue }}"
                                                wire:model="selectedAnswers.{{ $exercise->id }}"
                                                class="h-4 w-4"
                                            >

                                            <span class="font-medium">
                                                {{ $optionLabel }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            @if(isset($feedback[$exercise->id]))
                                <div class="mt-5 rounded-xl p-4 text-sm font-medium
                                    {{ $feedback[$exercise->id]['is_correct']
                                        ? 'bg-green-50 text-green-700 ring-1 ring-green-200 dark:bg-green-950 dark:text-green-300 dark:ring-green-900'
                                        : 'bg-red-50 text-red-700 ring-1 ring-red-200 dark:bg-red-950 dark:text-red-300 dark:ring-red-900' }}">
                                    {{ $feedback[$exercise->id]['message'] }}
                                </div>
                            @endif

                            @if(isset($adaptiveRecommendation[$exercise->id]))
                                <div class="mt-4 rounded-xl border border-amber-700 bg-amber-950 p-4 text-sm text-amber-100">
                                    <p class="font-semibold">
                                        {{ $adaptiveRecommendation[$exercise->id]['title'] }}
                                    </p>

                                    <p class="mt-1 text-amber-200">
                                        {{ $adaptiveRecommendation[$exercise->id]['message'] }}
                                    </p>
                                </div>
                            @endif

                            @if($isLessonCompleted)
                                <div class="mt-4 rounded-xl border border-green-700 bg-green-950 p-4 text-sm text-green-100">
                                    <p class="font-semibold">
                                        Lesson completada
                                    </p>

                                    <p class="mt-1 text-green-200">
                                        Terminaste correctamente todos los ejercicios de esta lesson.
                                    </p>
                                </div>
                            @endif

                            <div class="mt-6 flex flex-col gap-3">
                                @if(! $isLessonCompleted)
                                    <x-filament::button
                                        color="primary"
                                        wire:click="submitAnswer({{ $exercise->id }})"
                                    >
                                        Enviar respuesta
                                    </x-filament::button>
                                @endif

                                @if($isLessonCompleted)
                                    <a
                                        href="{{ url('/student/student-dashboard') }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                                    >
                                        Volver a mi aprendizaje
                                    </a>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-300 p-6 text-center dark:border-white/10">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Esta lesson todavía no tiene ejercicios.
                            </p>
                        </div>
                    @endforelse
                </section>
            </aside>

        </div>
    </div>
</x-filament-panels::page>
