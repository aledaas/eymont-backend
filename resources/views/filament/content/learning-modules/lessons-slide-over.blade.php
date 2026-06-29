<div class="space-y-4">

    <div>
        <h2 class="text-lg font-bold">
            {{ $module->title }}
        </h2>

        <p class="text-sm text-gray-500">
            Lessons asociadas a este módulo.
        </p>
    </div>

    @if ($lessons->isEmpty())

        <div class="rounded-lg border border-dashed p-6 text-center">
            Este módulo todavía no tiene lessons.
        </div>

    @else

        <div class="space-y-3">

            @foreach ($lessons as $lesson)

                <div class="rounded-xl border p-4">

                    <div class="flex items-center justify-between">

                        <div>
                            <div class="font-semibold">
                                {{ $lesson->order }}.
                                {{ $lesson->title }}
                            </div>

                            <div class="text-sm text-gray-500">
                                {{ $lesson->description }}
                            </div>
                        </div>

                        <div class="text-right text-sm">
                            <div>{{ $lesson->difficulty }}</div>
                            <div>{{ $lesson->status }}</div>
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>
