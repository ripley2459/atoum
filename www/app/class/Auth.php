<?php

class Auth
{
    private static bool $_open = false;

    private function __construct()
    {
        // Not instantiable!
    }

    /**
     * Starts a session and initializes the necessary parameters aka the session ID and a security token.
     * @param mixed ...$args Additional arguments for session_start().
     * @return bool Returns true if the session is successfully started, false otherwise.
     */
    public static function start(mixed...$args): bool
    {
        try {
            if (!self::$_open) {
                self::$_open = session_start($args);
                R::checkArgument(self::$_open, 'Failed to start the session!');
                self::generateToken();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return self::$_open;
    }

    /**
     * Generates a unique token and stores it in the session if not already set.
     * @throws Exception If there is an error generating random bytes.
     */
    private static function generateToken(): void
    {
        if (R::blank($_SESSION['token'])) {
            $token = R::EMPTY;

            try {
                $bytes = base64_encode(random_bytes(128));
                $token = preg_replace('/[+=\/.]/', '', $bytes);
                $token = substr($token, 0, 128);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $_SESSION['token'] = $token;
        }
    }

    /**
     * Closes the session It performs necessary operations like destroying the session, clearing cookies if applicable, and updating internal state variables. It returns a boolean indicating the success of the operation.
     * @return bool Returns false if the session is not open after the operation.
     */
    public static function close(): bool
    {
        if (self::$_open) {
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params['path'], $params['domain'],
                    $params['secure'], $params['httponly']
                );
            }

            $_SESSION = [];
            self::$_open = !session_destroy();
            R::checkArgument(!self::$_open, 'Failed to destroy the session!');
        }

        return self::$_open;
    }

    /**
     * Sets a variable value in the $_SESSION superglobal.
     * @param string $name The variable name.
     * @param mixed $value The variable value.
     * @return void
     */
    public static function set(string $name, mixed $value): void
    {
        $_SESSION[$name] = $value;
    }

    public static function verifyToken(string $token): void
    {
        R::checkArgument(self::getToken() === $token, 'Invalid token!');
    }

    public static function getToken(): string
    {
        return self::get('token');
    }

    /**
     * Gets the variable value from the $_SESSION superglobal.
     * @param string $name
     * @return mixed
     */
    public static function get(string $name): mixed
    {
        return $_SESSION[$name];
    }

    public static function getTokenField(): string
    {
        return '<input type="hidden" id="token" name="token" value="' . self::getToken() . '" required/>';
    }

    public static function isLoggedIn(): bool
    {
        return true; // Debug
        $id = self::get('accountID');
        return !R::blank($id);
    }
}