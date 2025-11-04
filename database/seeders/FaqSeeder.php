<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $general = Category::where('slug', 'general')->first();
        $payments = Category::where('slug', 'payments-billing')->first();

        if (!$general || !$payments) {
            $this->command?->warn('Run CategorySeeder before FaqSeeder.');
            return;
        }

        DB::transaction(function () use ($general, $payments) {
            // General (adapted from Big Apple Buddy FAQ for our AU->BD service)
            $generalFaqs = [
                [
                    'question' => 'What is BorderlesShopping?',
                    'answer' => "BorderlesShopping is a shopping concierge service based in Australia. We help customers in Bangladesh buy from Australian online stores. Once you confirm your quote, we purchase your items from reputable Australian stores and ship them to your Bangladesh address. We handle the entire process end-to-end so you don’t have to.",
                    'order' => 0,
                ],
                [
                    'question' => 'How does your service work?',
                    'answer' => "It’s simple:\n\n1. Send us product links and request a quote.\n2. We share a transparent quote (product price, domestic fees if any, international shipping, and service fee).\n3. After payment, we purchase your items, receive them at our Australian facility, inspect and repack, prepare all shipping and customs documentation, and ship to your address in Bangladesh.\n\nWe take care of the entire process from sourcing to delivery.",
                    'order' => 1,
                ],
                [
                    'question' => 'When should I use BorderlesShopping?',
                    'answer' => "Use our service when you want to buy:\n\n1. Australian products not available in Bangladesh\n2. From Australian stores that don’t ship internationally\n3. From Australian stores that require an Australian address\n4. From Australian stores that only accept Australian payment methods\n5. From stores that do not ship to parcel forwarders (we are not a parcel forwarder; we are a concierge)",
                    'order' => 2,
                ],
                [
                    'question' => 'How long will delivery take?',
                    'answer' => "Typical timeframes:\n\n- Store to our Australian facility: usually 2–7 business days (depends on the store).\n- Australian facility to Bangladesh: generally 1–8 business days, depending on courier and service level.\n\nYour estimated delivery window is shown in your quote and order confirmation.",
                    'order' => 3,
                ],
                [
                    'question' => 'Are the items brand-new and authentic?',
                    'answer' => "We only purchase from reliable suppliers and official Australian retailers. We do not assist with used, refurbished, or open‑box items due to higher risk of defects.",
                    'order' => 4,
                ],
                [
                    'question' => 'Will I be charged customs duties or import taxes?',
                    'answer' => "Customs duties and import taxes are assessed by Bangladesh customs and depend on product category and order value. We can estimate these in your quote when possible, but final charges are determined by authorities. You may also contact your local customs office for guidance.",
                    'order' => 5,
                ],
            ];

            foreach ($generalFaqs as $i => $faq) {
                Faq::updateOrCreate(
                    [
                        'category_id' => $general->id,
                        'question' => $faq['question'],
                    ],
                    [
                        'answer' => $faq['answer'],
                        'order' => $faq['order'] ?? $i,
                        'is_active' => true,
                    ]
                );
            }

            // Payments & Billing (adapted from Big Apple Buddy Payments section)
            $paymentFaqs = [
                [
                    'question' => 'When do I pay?',
                    'answer' => "Payment in full is required after you approve the quote and before we purchase your items. The quote link lets you confirm shipping and complete payment.",
                    'order' => 0,
                ],
                [
                    'question' => 'What payment methods do you accept?',
                    'answer' => "We accept bank transfer and popular mobile banking in Bangladesh (bKash, Nagad, Rocket). Card payments may be available via our processor depending on the order. Any processor surcharges will be shown in your quote when applicable.",
                    'order' => 1,
                ],
                [
                    'question' => 'Do you offer cash on delivery (COD)?',
                    'answer' => "No. We don’t offer COD. Full payment is required before we purchase items on your behalf.",
                    'order' => 2,
                ],
                [
                    'question' => 'Do you offer financing?',
                    'answer' => "We don’t offer financing or installment plans. Orders are paid in full prior to purchase.",
                    'order' => 3,
                ],
                [
                    'question' => 'Can I pay in BDT?',
                    'answer' => "Yes. Quotes are shown in BDT by default. If AUD is referenced, the payable BDT amount is determined at invoice/payment time using the prevailing exchange rate.",
                    'order' => 4,
                ],
                [
                    'question' => 'Is my payment information secure?',
                    'answer' => "Card payments (when available) are processed through our PCI‑compliant payment provider. We do not store card details. Bank and mobile wallet payments are completed through your bank’s secure channels.",
                    'order' => 5,
                ],
                [
                    'question' => 'Can I get an invoice or receipt for my order?',
                    'answer' => "Yes, we provide a BorderlesShopping invoice with a clear cost breakdown. Store receipts usually include our internal billing/shipping info and are not shared. We cannot split payments, address invoices to third parties, or back‑date invoices.",
                    'order' => 6,
                ],
                [
                    'question' => 'Can I use different billing and shipping addresses?',
                    'answer' => "Yes, you can submit different billing and shipping addresses to place your order. Note: customs invoices from the courier are addressed to the shipping/import address.",
                    'order' => 7,
                ],
                [
                    'question' => 'Can I pay with a store gift card?',
                    'answer' => "We cannot apply retailer/store gift cards on your behalf.",
                    'order' => 8,
                ],
                [
                    'question' => 'Can I pay with a credit or debit card?',
                    'answer' => "Where available, we accept major cards via our payment processor. Any applicable processing surcharge will be disclosed in your quote.",
                    'order' => 9,
                ],
                [
                    'question' => 'Can I get the store order number for my purchase?',
                    'answer' => "We typically cannot provide the retailer’s internal order number as it contains our account details. We keep you updated through BorderlesShopping order references and tracking numbers.",
                    'order' => 10,
                ],
            ];

            foreach ($paymentFaqs as $i => $faq) {
                Faq::updateOrCreate(
                    [
                        'category_id' => $payments->id,
                        'question' => $faq['question'],
                    ],
                    [
                        'answer' => $faq['answer'],
                        'order' => $faq['order'] ?? $i,
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
