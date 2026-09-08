@extends('layouts.app')

@section('title', 'FAQ - Akademik POLNEP')

@section('content')
    <section class="bg-[#f4f7f8] pb-16 pt-12 sm:pb-20 sm:pt-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="font-outfit text-3xl font-extrabold uppercase leading-none text-[#7bc8e5] sm:text-5xl">Frequently Asked</h1>
                <h2 class="font-outfit text-3xl font-extrabold uppercase leading-none text-[#103e68] sm:text-5xl">Questions</h2>
                <p class="mx-auto mt-5 max-w-3xl text-sm font-bold uppercase leading-6 text-[#5e6870] sm:text-base">
                    Temukan jawaban atas pertanyaan yang sering diajukan seputar layanan informasi akademik Politeknik Negeri Pontianak.
                </p>
            </div>

            <div class="mx-auto mt-10 max-w-4xl space-y-3">
                @forelse ($faqs as $index => $faq)
                    <div class="overflow-hidden rounded-xl bg-[#89cbe5] shadow-sm">
                        <button type="button" class="faq-toggle flex w-full items-center justify-between gap-5 px-5 py-4 text-left text-sm font-extrabold uppercase text-[#102b3c] sm:px-7 sm:py-5" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="faq-answer-{{ $faq->id }}">
                            <span>{{ $faq->question }}</span>
                            <i class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform {{ $index === 0 ? 'rotate-180' : '' }}"></i>
                        </button>
                        <div id="faq-answer-{{ $faq->id }}" class="faq-answer {{ $index === 0 ? '' : 'hidden' }} bg-[#d9edf4] px-5 py-4 text-sm leading-6 text-[#5e6870] sm:px-7">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @empty
                    <p class="rounded-xl bg-white px-6 py-10 text-center text-sm text-slate-500">Belum ada pertanyaan yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.querySelectorAll('.faq-toggle').forEach((toggle) => {
                toggle.addEventListener('click', () => {
                    const answer = document.getElementById(toggle.getAttribute('aria-controls'));
                    const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                    toggle.setAttribute('aria-expanded', String(!isOpen));
                    answer.classList.toggle('hidden', isOpen);
                    toggle.querySelector('i').classList.toggle('rotate-180', !isOpen);
                });
            });
        </script>
    @endpush
@endsection
