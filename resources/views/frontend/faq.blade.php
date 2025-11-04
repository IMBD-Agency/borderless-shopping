@extends('layouts.frontend')

@section('content')
    <div class="track-order-page">
        <!-- Header -->
        <div class="tracking-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <h1 class="tracking-title">Frequently Asked Questions</h1>
                        <p class="tracking-subtitle">Find answers to common questions about our service</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="tracking-form-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        @if ($faqs->isEmpty())
                            <div class="tracking-form-card">
                                <div class="card-body text-center py-5">
                                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No FAQs available at the moment. Please check back later.</p>
                                </div>
                            </div>
                        @else
                            @php
                                // Group FAQs by category relationship
                                $groupedFaqs = $faqs->groupBy(function($faq) {
                                    return $faq->category ? $faq->category->name : 'Uncategorized';
                                });
                            @endphp

                            @foreach ($groupedFaqs as $categoryName => $categoryFaqs)
                                <div class="faq-category-section mb-4">
                                    <div class="tracking-form-card">
                                        <div class="card-header">
                                            <h3 class="card-title mb-0">
                                                <i class="fas fa-folder me-2"></i>{{ $categoryName }}
                                            </h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="accordion accordion-flush" id="accordion{{ Str::slug($categoryName) }}">
                                                @foreach ($categoryFaqs as $index => $faq)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
                                                                {{ $faq->question }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion{{ Str::slug($categoryName) }}">
                                                            <div class="accordion-body">
                                                                <div class="faq-answer">
                                                                    {!! nl2br(e($faq->answer)) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Contact Section -->
                            <div class="quick-actions-card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-envelope me-2"></i>Still have questions?</h3>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">Can't find what you're looking for? We're here to help!</p>
                                    @if (!empty($contact_details?->email))
                                        <a href="mailto:{{ $contact_details->email }}" class="btn btn-outline me-2">
                                            <i class="fas fa-envelope me-2"></i>{{ $contact_details->email }}
                                        </a>
                                    @endif
                                    @if (!empty($contact_details?->phone))
                                        <a href="tel:{{ $contact_details->phone }}" class="btn btn-outline">
                                            <i class="fas fa-phone me-2"></i>{{ $contact_details->phone }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .faq-category-section {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .accordion-button {
            font-weight: 600;
            color: var(--dark-color);
            background-color: #f8f9fa;
            border: none;
            box-shadow: none;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--accent-color);
            color: white;
        }

        .accordion-button:not(.collapsed)::after {
            filter: brightness(0) invert(1);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(236, 29, 37, 0.25);
            border-color: var(--accent-color);
        }

        .accordion-item {
            border: 1px solid #e9ecef;
            border-radius: 0;
        }

        .accordion-item:first-of-type {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .accordion-item:last-of-type {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .accordion-body {
            padding: 1.5rem;
            background-color: white;
        }

        .faq-answer {
            line-height: 1.8;
            color: #555;
        }

        .faq-answer p {
            margin-bottom: 0.5rem;
        }

        .faq-answer p:last-child {
            margin-bottom: 0;
        }
    </style>
    @endpush
@endsection

