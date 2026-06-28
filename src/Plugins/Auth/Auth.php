<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Plugins\Auth;

use Phalcon\Di\Injectable;
use Phalcon\Http\Response;
use Vokuro\Models\FailedLogins;
use Vokuro\Models\RememberTokens;
use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

/**
 * Vokuro\Auth\Auth
 * Manages Authentication/Identity Management in Vokuro
 */
class Auth extends Injectable
{
    /**
     * Auths the user by his/her id
     *
     * @param int $id
     *
     * @throws Exception
     */
    public function authUserById($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            throw new Exception('The user does not exist');
        }

        $this->checkUserFlags($user);

        $this->session->set('auth-identity', [
            'id'      => $user->id,
            'name'    => $user->name,
            'profile' => $user->profile->name,
        ]);
    }
    /**
     * Checks the user credentials
     *
     * @param array $credentials
     *
     * @throws Exception
     */
    public function check($credentials)
    {
        // Check if the user exist
        $user = Users::findFirstByEmail($credentials['email']);
        if (!$user) {
            $this->registerUserThrottling(0);
            throw new Exception('Wrong email/password combination');
        }

        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->password)) {
            $this->registerUserThrottling($user->id);
            throw new Exception('Wrong email/password combination');
        }

        // Check if the user was flagged
        $this->checkUserFlags($user);

        // Register the successful login
        $this->saveSuccessLogin($user);

        // Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->createRememberEnvironment($user);
        }

        $this->session->set('auth-identity', [
            'id'      => $user->id,
            'name'    => $user->name,
            'profile' => $user->profile->name,
        ]);
    }

    /**
     * Checks if the user is banned/inactive/suspended
     *
     * @param Users $user
     *
     * @throws Exception
     */
    public function checkUserFlags(Users $user)
    {
        if ($user->active != 'Y') {
            throw new Exception('The user is inactive');
        }

        if ($user->banned != 'N') {
            throw new Exception('The user is banned');
        }

        if ($user->suspended != 'N') {
            throw new Exception('The user is suspended');
        }
    }

    /**
     * Creates the remember me environment settings the related cookies and
     * generating tokens
     *
     * @param Users $user
     */
    public function createRememberEnvironment(Users $user)
    {
        // The raw token goes to the cookie; only its hash is stored, so a leaked
        // database row cannot be replayed as a valid remember-me cookie.
        $token = bin2hex(random_bytes(16));

        $remember            = new RememberTokens();
        $remember->usersId   = $user->id;
        $remember->token     = hash('sha256', $token);
        $remember->userAgent = $this->request->getUserAgent();

        if ($remember->save()) {
            $expire = time() + 86400 * 8;
            $this->cookies->set('RMU', $user->id, $expire);
            $this->cookies->set('RMT', $token, $expire);
        }
    }

    /**
     * Delete the current user token in session
     *
     * @param int $userId
     */
    public function deleteToken(int $userId): void
    {
        $user = RememberTokens::find([
            'conditions' => 'usersId = :userId:',
            'bind'       => [
                'userId' => $userId,
            ],
        ]);

        if ($user) {
            $user->delete();
        }
    }

    /**
     * Returns the current token user
     *
     * @param string $token
     *
     * @return int|null
     */
    public function findFirstByToken($token)
    {
        $userToken = RememberTokens::findFirst([
            'conditions' => 'token = :token:',
            'bind'       => [
                'token' => $token,
            ],
        ]);

        return $userToken ? $userToken->usersId : null;
    }

    /**
     * Returns the current identity
     *
     * @return array|null
     */
    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
        $identity = $this->session->get('auth-identity');
        return $identity['name'];
    }

    /**
     * Get the entity related to user in the active identity
     *
     * @return Users
     * @throws Exception
     */
    public function getUser()
    {
        $identity = $this->session->get('auth-identity');

        if (!isset($identity['id'])) {
            throw new Exception('Session was broken. Try to re-login');
        }

        $user = Users::findFirstById($identity['id']);
        if (!$user) {
            throw new Exception('The user does not exist');
        }

        return $user;
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the cookies
     *
     * @return Response
     * @throws Exception
     */
    public function loginWithRememberMe()
    {
        $userId      = $this->cookies->get('RMU')->getValue();
        $cookieToken = (string) $this->cookies->get('RMT')->getValue();

        $user = Users::findFirstById($userId);
        if ($user) {
            $tokenHash = hash('sha256', $cookieToken);
            $remember  = RememberTokens::findFirst([
                'usersId = ?0 AND token = ?1',
                'bind' => [
                    $user->id,
                    $tokenHash,
                ],
            ]);

            // Confirm the stored hash in constant time and that the cookie is still valid
            if (
                $remember
                && hash_equals((string) $remember->token, $tokenHash)
                && ((time() - $remember->createdAt) / (86400 * 8)) < 8
            ) {
                $this->checkUserFlags($user);

                $this->session->set('auth-identity', [
                    'id'      => $user->id,
                    'name'    => $user->name,
                    'profile' => $user->profile->name,
                ]);

                $this->saveSuccessLogin($user);

                return $this->response->redirect('users');
            }
        }

        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();

        return $this->response->redirect('session/login');
    }

    /**
     * Implements login throttling
     * Reduces the effectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function registerUserThrottling($userId)
    {
        $failedLogin            = new FailedLogins();
        $failedLogin->usersId   = $userId;
        $failedLogin->ipAddress = $this->request->getClientAddress();
        $failedLogin->attempted = time();
        $failedLogin->save();

        $attempts = FailedLogins::count([
            'ipAddress = ?0 AND attempted >= ?1',
            'bind' => [
                $this->request->getClientAddress(),
                time() - 3600 * 6,
            ],
        ]);

        switch ($attempts) {
            case 1:
            case 2:
                // no delay
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            default:
                sleep(4);
                break;
        }
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }
        if ($this->cookies->has('RMT')) {
            $token = $this->cookies->get('RMT')->getValue();

            $userId = $this->findFirstByToken($token);
            if ($userId) {
                $this->deleteToken($userId);
            }

            $this->cookies->get('RMT')->delete();
        }

        $this->session->remove('auth-identity');
    }

    /**
     * Creates the remember me environment settings the related cookies and
     * generating tokens
     *
     * @param Users $user
     *
     * @throws Exception
     */
    public function saveSuccessLogin($user)
    {
        $successLogin            = new SuccessLogins();
        $successLogin->usersId   = $user->id;
        $successLogin->ipAddress = $this->request->getClientAddress();
        $successLogin->userAgent = $this->request->getUserAgent();
        if (!$successLogin->save()) {
            $messages = $successLogin->getMessages();
            throw new Exception($messages[0]);
        }
    }
}
