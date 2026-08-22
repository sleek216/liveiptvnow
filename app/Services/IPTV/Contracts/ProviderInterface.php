<?php

namespace App\Services\IPTV\Contracts;

interface ProviderInterface
{
    /**
     * Authenticate with the provider API.
     */
    public function authenticate(): bool;

    /**
     * Create a new IPTV line.
     * 
     * @param array $data Contains package_id, duration, username, password, bouquets
     * @return array Contains success, client_id, message
     */
    public function createLine(array $data): array;

    /**
     * Renew an existing IPTV line.
     */
    public function renewLine(string $clientId, array $data): array;

    /**
     * Disable/Enable an existing line.
     */
    public function toggleLine(string $clientId, bool $status): array;
}
