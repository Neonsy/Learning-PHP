<?php

declare(strict_types=1);

namespace MVCSpace\Core\Service\Services;

class SessionManager
{
    /**
     * @see https://www.php.net/manual/en/function.session-set-cookie-params.php
     * @param int $lifetime The cookie lifetime in seconds
     */
    public function __construct(int $lifetime = 60 * 30)
    {
        // 1. Only use cookies when storing the session ID for improved security
        ini_set('session.use_only_cookies', true);

        // 2. Only use session IDS created by the server
        ini_set('session.use_strict_mode', true);

        // 3. Configure session
        session_set_cookie_params([
            'lifetime' => $lifetime, // Cookie lifetime in seconds
            'domain' => '', // Cookie Domain (Needs to be empty in case of localhost, or it won't work)
            'path' => '/', // Sub-paths the cookie will be available at
            'secure' => true, // Only sent over HTTPS (Won't have an effect in this case)
            'httponly' => true, // Only sent over HTTP protocol
        ]);

        // 4. Start session after configuration
        session_start();

        // 5. Regenerate session ID after lifetime is over
        if (!isset($_SESSION['lastRegen'])) {
            $this->regenerateID();
        } else {
            // If it's set, we need to check if the time's up
            if (time() - $_SESSION['lastRegen'] >= $lifetime) {
                $this->regenerateID();
            }
        }
    }

    /**
     * Regenerates the session ID for improved security
     * @return void
     */
    private function regenerateID(): void
    {
        session_regenerate_id(true);

        // Store the time of the last regeneration.
        $_SESSION['lastRegen'] = time();
    }

    /**
     * Set a session variable.
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    // Check if a session variable has been set already.
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Get the value of a session variable.
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    /**
     * Remove a session variable.
     * @param string $key
     * @return void
     */
    public function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy the session.
     * @return void
     */
    public function destroy(): void
    {
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }

        session_destroy();
    }
}