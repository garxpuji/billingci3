<?php

namespace App\Services\Mikrotik;

use RouterOS\Client;
use RouterOS\Query;
use Exception;
use Illuminate\Support\Facades\Log;

class MikrotikService
{
    protected ?Client $client = null;
    protected array $config;

    public function __construct()
    {
        $this->config = config('billing.mikrotik', []);
    }

    /**
     * Connect to Mikrotik router
     */
    public function connect(array $routerConfig): bool
    {
        try {
            $this->client = new Client([
                'host' => $routerConfig['ip_address'],
                'port' => (int) ($routerConfig['port'] ?? 8728),
                'user' => $routerConfig['username'],
                'pass' => $routerConfig['password'],
                'timeout' => 10,
                'attempts' => 2,
            ]);

            return true;
        } catch (Exception $e) {
            Log::error("Mikrotik connection failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Disconnect from router
     */
    public function disconnect(): void
    {
        if ($this->client) {
            $this->client = null;
        }
    }

    /**
     * Add PPPoE secret (user)
     */
    public function addPppoeSecret(string $username, string $password, string $profile, string $comment = ''): bool
    {
        try {
            $query = (new Query('/ppp/secret/add'))
                ->equal('name', $username)
                ->equal('password', $password)
                ->equal('profile', $profile)
                ->equal('comment', $comment)
                ->equal('service', 'pppoe')
                ->equal('disabled', 'no');

            $this->client->query($query)->read();

            return true;
        } catch (Exception $e) {
            Log::error("Failed to add PPPoE secret: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update PPPoE secret
     */
    public function updatePppoeSecret(string $username, array $data): bool
    {
        try {
            // Find the secret first
            $findQuery = (new Query('/ppp/secret/print'))
                ->where('name', $username);

            $result = $this->client->query($findQuery)->read();

            if (empty($result)) {
                return $this->addPppoeSecret(
                    $username,
                    $data['password'] ?? '',
                    $data['profile'] ?? 'default',
                    $data['comment'] ?? ''
                );
            }

            $id = $result[0]['.id'];

            $updateQuery = (new Query('/ppp/secret/set'))
                ->equal('.id', $id);

            foreach ($data as $key => $value) {
                $updateQuery->equal($key, $value);
            }

            $this->client->query($updateQuery)->read();

            return true;
        } catch (Exception $e) {
            Log::error("Failed to update PPPoE secret: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove PPPoE secret
     */
    public function removePppoeSecret(string $username): bool
    {
        try {
            $findQuery = (new Query('/ppp/secret/print'))
                ->where('name', $username);

            $result = $this->client->query($findQuery)->read();

            if (!empty($result)) {
                $id = $result[0]['.id'];

                $removeQuery = (new Query('/ppp/secret/remove'))
                    ->equal('.id', $id);

                $this->client->query($removeQuery)->read();
            }

            return true;
        } catch (Exception $e) {
            Log::error("Failed to remove PPPoE secret: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Enable PPPoE secret
     */
    public function enablePppoeSecret(string $username): bool
    {
        return $this->updatePppoeSecret($username, ['disabled' => 'no']);
    }

    /**
     * Disable PPPoE secret (isolir)
     */
    public function disablePppoeSecret(string $username): bool
    {
        return $this->updatePppoeSecret($username, ['disabled' => 'yes']);
    }

    /**
     * Get active PPPoE connections
     */
    public function getActiveConnections(?string $username = null): array
    {
        try {
            $query = new Query('/ppp/active/print');

            if ($username) {
                $query->where('name', $username);
            }

            return $this->client->query($query)->read();
        } catch (Exception $e) {
            Log::error("Failed to get active connections: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Kick/disconnect active user
     */
    public function kickUser(string $username): bool
    {
        try {
            $connections = $this->getActiveConnections($username);

            foreach ($connections as $connection) {
                if (isset($connection['.id'])) {
                    $kickQuery = (new Query('/ppp/active/remove'))
                        ->equal('.id', $connection['.id']);

                    $this->client->query($kickQuery)->read();
                }
            }

            return true;
        } catch (Exception $e) {
            Log::error("Failed to kick user: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Isolir customer (disable + kick)
     */
    public function isolirCustomer(string $username): bool
    {
        $disabled = $this->disablePppoeSecret($username);
        $kicked = $this->kickUser($username);

        return $disabled && $kicked;
    }

    /**
     * Open isolir (enable)
     */
    public function openIsolir(string $username): bool
    {
        return $this->enablePppoeSecret($username);
    }

    /**
     * Get all PPPoE secrets
     */
    public function getAllSecrets(): array
    {
        try {
            $query = new Query('/ppp/secret/print');

            return $this->client->query($query)->read();
        } catch (Exception $e) {
            Log::error("Failed to get all secrets: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if user exists
     */
    public function userExists(string $username): bool
    {
        $secrets = $this->getAllSecrets();

        foreach ($secrets as $secret) {
            if (($secret['name'] ?? '') === $username) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get router status/info
     */
    public function getSystemInfo(): array
    {
        try {
            $identityQuery = new Query('/system/identity/print');
            $identity = $this->client->query($identityQuery)->read();

            $resourceQuery = new Query('/system/resource/print');
            $resource = $this->client->query($resourceQuery)->read();

            return [
                'identity' => $identity[0]['name'] ?? 'Unknown',
                'resource' => $resource[0] ?? [],
            ];
        } catch (Exception $e) {
            Log::error("Failed to get system info: " . $e->getMessage());
            return [];
        }
    }
}
