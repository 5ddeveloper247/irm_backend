<?php

namespace App\Services;

use App\Models\BookLibrary;
use Illuminate\Support\Str;

class BookService
{
    public function resolveByIdOrSlug(string|int $identifier): ?BookLibrary
    {
        $query = BookLibrary::with('bookcategory')->where('status', 1);

        if (is_numeric($identifier)) {
            return $query->where('id', (int) $identifier)->first();
        }

        return $query->where('slug', $identifier)->first();
    }

    public function resolveByIdOrSlugAnyStatus(string|int $identifier): ?BookLibrary
    {
        $query = BookLibrary::with('bookcategory');

        if (is_numeric($identifier)) {
            return $query->where('id', (int) $identifier)->first();
        }

        return $query->where('slug', $identifier)->first();
    }

    public function generateSlug(string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'book';
        }

        $slug = $base;
        $counter = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function formatForApi(BookLibrary $book, bool $includeOrderConfig = false): array
    {
        $book->loadMissing('bookcategory');

        $currency = strtoupper($book->currency ?? 'PKR');
        $slug = $book->slug ?? $this->generateSlug($book->title ?? 'book', $book->id);

        $formatted = [
            'id' => $book->id,
            'title' => $book->title,
            'slug' => $slug,
            'description' => $book->description,
            'price' => (float) ($book->price ?? 0),
            'currency' => $currency,
            'currency_symbol' => $this->currencySymbol($currency),
            'delivery_charge_local' => (float) ($book->delivery_charge_local ?? 0),
            'delivery_charge_international' => (float) ($book->delivery_charge_international ?? 0),
            'date' => $book->date,
            'status' => (int) $book->status,
            'book_homepage' => (int) ($book->book_homepage ?? 0),
            'book_category_id' => $book->book_category_id,
            'category_name' => $book->bookcategory?->title,
            'book_name' => $book->book_name,
            'thumbnail' => $book->thumbnail ? url('/' . $book->thumbnail) : null,
            'pdf' => $book->book ? url('/' . $book->book) : null,
            'book_path' => $book->book,
            'book_url' => '/books/' . $slug,
            'view_url' => url('/api/viewBook/' . $slug),
            'download_url' => url('/api/downloadBook/' . $slug),
            'created_at' => $book->created_at,
            'updated_at' => $book->updated_at,
        ];

        if ($includeOrderConfig) {
            $formatted['order_config'] = $this->getOrderConfig($book);
        }

        return $formatted;
    }

    public function getOrderConfig(BookLibrary $book): array
    {
        $currency = strtoupper($book->currency ?? 'PKR');

        return [
            'module_code' => 'BOOK',
            'payment_type' => 'book_order',
            'is_donation' => false,
            'is_book_order' => true,
            'book_id' => $book->id,
            'currency' => $currency,
            'currency_symbol' => $this->currencySymbol($currency),
            'book_price' => (float) ($book->price ?? 0),
            'delivery_options' => [
                [
                    'country_code' => 'PK',
                    'country_label' => 'Pakistan',
                    'delivery_charge' => (float) ($book->delivery_charge_local ?? 0),
                    'currency' => $currency,
                ],
                [
                    'country_code' => 'INT',
                    'country_label' => 'International',
                    'delivery_charge' => (float) ($book->delivery_charge_international ?? 0),
                    'currency' => $currency,
                ],
            ],
            'payment_methods' => ['jazz_cash', 'easypaisa', 'bank_transfer'],
            'totals_preview' => [
                'PK' => $this->calculateOrderTotal($book, 'PK'),
                'INT' => $this->calculateOrderTotal($book, 'INT'),
            ],
        ];
    }

    public function calculateOrderTotal(BookLibrary $book, string $country = 'PK'): array
    {
        $bookPrice = (float) ($book->price ?? 0);
        $delivery = $this->getDeliveryCharge($book, $country);
        $total = $bookPrice + $delivery;

        return [
            'book_price' => $bookPrice,
            'delivery_charge' => $delivery,
            'total_amount' => $total,
            'currency' => strtoupper($book->currency ?? 'PKR'),
        ];
    }

    public function getDeliveryCharge(BookLibrary $book, string $country): float
    {
        $normalized = strtoupper(trim($country));

        if ($normalized === 'PK' || $normalized === 'PAKISTAN') {
            return (float) ($book->delivery_charge_local ?? 0);
        }

        return (float) ($book->delivery_charge_international ?? 0);
    }

    public function validateBookOrder(array $submit, float $amount): ?string
    {
        $bookId = $submit['book_id'] ?? $submit['campaign_id'] ?? null;

        if (empty($bookId)) {
            return 'Book ID is required for book orders.';
        }

        $book = BookLibrary::where('id', $bookId)->where('status', 1)->first();

        if (!$book) {
            return 'Selected book is not available.';
        }

        $country = $submit['country'] ?? 'PK';
        $expected = $this->calculateOrderTotal($book, $country);

        if (abs($amount - $expected['total_amount']) > 0.01) {
            return 'Order amount does not match book price and delivery charges.';
        }

        return null;
    }

    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = BookLibrary::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    private function currencySymbol(string $currency): string
    {
        return match (strtoupper($currency)) {
            'PKR' => 'Rs',
            'USD' => '$',
            default => strtoupper($currency),
        };
    }
}
