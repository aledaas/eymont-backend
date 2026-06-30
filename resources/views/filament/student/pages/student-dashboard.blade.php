<x-filament-panels::page>
    <div class="space-y-8">

        <div>
            <h1 class="text-2xl font-bold tracking-tight">
                Hola {{ $user->name }} 👋
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Continuemos con tu aprendizaje de inglés.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Módulos disponibles
                </div>

                <div class="mt-2 text-3xl font-bold">
                    {{ $modulesCount }}
                </div>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Lessons completadas
                </div>

                <div class="mt-2 text-3xl font-bold">
                    {{ $completedLessons }}
                </div>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Lessons dominadas
                </div>

                <div class="mt-2 text-3xl font-bold">
                    {{ $masteredLessons }}
                </div>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Tiempo estudiado
                </div>

                <div class="mt-2 text-3xl font-bold">
                    {{ $studyTime }} min
                </div>
            </div>

        </div>

        @if (count($frequentErrors) > 0)

            <div
                class="grid gap-6"
                style="grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); align-items: stretch;"
            >

                {{-- Errores frecuentes --}}
                <div class="h-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

                    <h2 class="text-lg font-semibold text-gray-950 dark:text-white">
                        Tus errores frecuentes
                    </h2>

                    <div class="mt-4 space-y-3">

                        @foreach ($frequentErrors as $error)

                            <div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-800">

                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            {{ $error['name'] }}
                        </span>

                                <span
                                    style="
                                background:#ef4444;
                                color:white;
                                padding:4px 12px;
                                border-radius:999px;
                                font-weight:bold;
                            ">
                            {{ $error['count'] }}
                        </span>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- Recomendación --}}
                @if ($topErrorPattern?->student_message)

                    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

                        <p class="text-sm font-semibold text-primary-600">
                            🎯 Recomendado para vos
                        </p>

                        <h2 class="mt-3 text-xl font-bold">
                            {{ $topErrorPattern->recommendedLesson?->title ?? 'Práctica recomendada' }}
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-300">
                            {{ $topErrorPattern->student_message }}
                        </p>

                        @if ($topErrorPattern->recommendedLesson)

                            <div class="mt-6">

                                <a
                                    href="{{ url('/student/lesson-player?lesson=' . $topErrorPattern->recommendedLesson->id) }}"
                                    style="
                    display:inline-block;
                    background:#f97316;
                    color:white;
                    padding:12px 24px;
                    border-radius:8px;
                    font-weight:600;
                    text-decoration:none;
                ">

                                    Practicar ahora →

                                </a>

                            </div>

                        @endif

                    </div>

                @endif

            </div>

        @endif

        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

            <div class="mb-5">
                <h2 class="text-lg font-semibold">
                    Módulos disponibles
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Elegí un módulo para continuar tu aprendizaje.
                </p>
            </div>

            <div class="space-y-4">

                @forelse($availableModules as $module)

                    <div class="flex items-center justify-between rounded-xl border border-gray-200 p-4 dark:border-white/10">

                        <div>
                            <h3 class="font-semibold">
                                {{ $module->title }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $module->description ?? 'Sin descripción disponible.' }}
                            </p>

                            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                {{ $module->lessons_count }} lessons disponibles
                            </p>
                        </div>

                        <div>
                            @php
                                $firstLesson = $module->lessons()
                                    ->orderBy('order')
                                    ->first();
                            @endphp

                            @if($firstLesson)
                                <a href="{{ url('/student/lesson-player?lesson=' . $firstLesson->id) }}">
                                    <button type="button">
                                        Continuar
                                    </button>
                                </a>
                            @else
                                <span class="text-sm text-gray-400">
                                    Sin lessons
                                </span>
                            @endif
                        </div>

                    </div>

                @empty

                    <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center dark:border-white/10">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Todavía no hay módulos publicados.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>

    </div>
</x-filament-panels::page>
