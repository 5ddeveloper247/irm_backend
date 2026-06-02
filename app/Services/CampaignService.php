<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Setting;

class CampaignService
{
    public function formatCampaignForApi(Campaign $campaign, float $totalAmount = 0): array
    {
        $campaign->loadMissing('tasks');

        $target = (float) ($campaign->target_amount ?? 0);
        $raised = (float) $totalAmount;
        $progress = $target > 0 ? min(100, round(($raised / $target) * 100, 1)) : 0;

        return [
            'id' => $campaign->id,
            'title' => $campaign->title,
            'tags' => $campaign->tags,
            'description' => $campaign->description,
            'welfare_section' => $campaign->welfare_section ?? 'general',
            'display_order' => (int) ($campaign->display_order ?? 0),
            'target_amount' => $target,
            'total_amount' => $raised,
            'progress' => $progress,
            'currency' => 'PKR',
            'currency_symbol' => 'Rs',
            'image' => $campaign->thumbnail ? url('/' . $campaign->thumbnail) : null,
            'thumbnail' => $campaign->thumbnail,
            'date' => $campaign->date,
            'status' => (int) $campaign->status,
            'tasks' => $campaign->tasks,
            'donation_config' => $this->getDonationConfig($campaign),
            'created_at' => $campaign->created_at,
            'updated_at' => $campaign->updated_at,
        ];
    }

    public function getDonationConfig(Campaign $campaign): array
    {
        return [
            'module_code' => 'DONATION',
            'payment_type' => 'donation',
            'is_donation' => true,
            'is_book_order' => false,
            'campaign_id' => $campaign->id,
            'title' => $campaign->title,
            'currency' => 'PKR',
            'currency_symbol' => 'Rs',
        ];
    }

    public function getPaymentAccounts(): array
    {
        $settings = Setting::first();

        if (!$settings) {
            return $this->defaultPaymentAccounts();
        }

        return [
            'currency' => 'PKR',
            'currency_symbol' => 'Rs',
            'jazz_cash' => [
                'account_title' => $settings->jazz_cash_account_title ?? '',
                'account_number' => $settings->jazz_cash_account_number ?? '',
                'display_label' => $this->paymentDisplayLabel(
                    $settings->jazz_cash_account_title,
                    $settings->jazz_cash_account_number
                ),
                'qr_image' => $this->fullUrl($settings->jazz_cash_qr),
            ],
            'easypaisa' => [
                'account_title' => $settings->easypaisa_account_title ?? '',
                'account_number' => $settings->easypaisa_account_number ?? '',
                'display_label' => $this->paymentDisplayLabel(
                    $settings->easypaisa_account_title,
                    $settings->easypaisa_account_number
                ),
                'qr_image' => $this->fullUrl($settings->easypaisa_qr),
            ],
            'bank_transfer' => [
                'account_title' => $settings->bank_account_title ?? '',
                'account_number' => $settings->bank_account_number ?? '',
                'bank_name' => $settings->bank_name ?? '',
                'display_label' => $this->paymentDisplayLabel(
                    $settings->bank_account_title,
                    $settings->bank_account_number,
                    $settings->bank_name
                ),
                'qr_image' => $this->fullUrl($settings->bank_qr),
            ],
        ];
    }

    public function resolveCampaignId(array $submit): ?int
    {
        $id = $submit['campaign_id'] ?? $submit['course_id'] ?? null;

        return $id ? (int) $id : null;
    }

    public function validateDonationCampaign(?int $campaignId): ?string
    {
        if (!$campaignId) {
            return 'Campaign ID is required for donations.';
        }

        $exists = Campaign::where('id', $campaignId)->where('status', 1)->exists();

        if (!$exists) {
            return 'Selected campaign is not available.';
        }

        return null;
    }

    private function paymentDisplayLabel(?string $title, ?string $number, ?string $extra = null): string
    {
        $parts = array_filter([
            $title,
            $number,
            $extra,
        ], fn ($v) => !empty(trim((string) $v)));

        return implode(' - ', $parts);
    }

    private function fullUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        return url('/' . ltrim($path, '/'));
    }

    private function defaultPaymentAccounts(): array
    {
        return [
            'currency' => 'PKR',
            'currency_symbol' => 'Rs',
            'jazz_cash' => [
                'account_title' => '',
                'account_number' => '',
                'display_label' => '',
                'qr_image' => null,
            ],
            'easypaisa' => [
                'account_title' => '',
                'account_number' => '',
                'display_label' => '',
                'qr_image' => null,
            ],
            'bank_transfer' => [
                'account_title' => '',
                'account_number' => '',
                'bank_name' => '',
                'display_label' => '',
                'qr_image' => null,
            ],
        ];
    }
}
