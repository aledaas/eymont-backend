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

        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="mb-5">
                <h2 class="text-lg font-semibold">
                    Módulos disponibles
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Elegí un módulo para continuar tu aprendizaje.
                </p>
            </div>

            <div class="space-y-3">
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

                        <x-filament::button
                            color="primary"
                            size="sm"
                        >
                            Continuar
                        </x-filament::button>
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
