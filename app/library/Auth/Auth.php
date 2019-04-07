<?php
namespace Vokuro\Auth;

use Phalcon\Plugin;
use Vokuro\Models\Users;
use Vokuro\Models\RememberTokens;
use Vokuro\Models\SuccessLogins;
use Vokuro\Models\FailedLogins;

/**
* Vokuro\Auth\Auth
* Manages Authentication/Identity Management in Vokuro
*/
class Auth extends Plugin
{
  /**
  * Checks the user credentials
  *
  * @param array $credentials
  * @return boolean
  * @throws Exception
  */
  public function check($credentials)
  {

    // Check if the user exist
    $user = Users::findFirstByEmail($credentials['email']);
    if ($user == false) {
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
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'role' => $user->role->name
    ]);
  }

  /**
  * Creates the remember me environment settings the related cookies and generating tokens
  *
  * @param \Vokuro\Models\Users $user
  * @throws Exception
  */
  public function saveSuccessLogin($user)
  {
    $successLogin = new SuccessLogins();
    $successLogin->userID = $user->id;
    $successLogin->ipAddress = $this->request->getClientAddress();
    $successLogin->userAgent = $this->request->getUserAgent();
    if (!$successLogin->save()) {
      $messages = $successLogin->getMessages();
      throw new Exception($messages[0]);
    }
  }

  /**
  * Implements login throttling
  * Reduces the effectiveness of brute force attacks
  *
  * @param int $userID
  */
  public function registerUserThrottling($userID)
  {
    $failedLogin = new FailedLogins();
    $failedLogin->userID = $userID;
    $failedLogin->ipAddress = $this->request->getClientAddress();
    $failedLogin->attempted = time();
    $failedLogin->save();

    $attempts = FailedLogins::count([
      'ipAddress = ?0 AND attempted >= ?1',
      'bind' => [
        $this->request->getClientAddress(),
        time() - 3600 * 6
      ]
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
  * Creates the remember me environment settings the related cookies and generating tokens
  *
  * @param \Vokuro\Models\Users $user
  */
  public function createRememberEnvironment(Users $user)
  {
    $userAgent = $this->request->getUserAgent();
    $token = md5($user->email . $user->password . $userAgent);

    $remember = new RememberTokens();
    $remember->userID = $user->id;
    $remember->token = $token;
    $remember->userAgent = $userAgent;

    if ($remember->save() != false) {
      $expire = time() + 86400 * 8;
      $this->cookies->set('RMU', $user->id, $expire);
      $this->cookies->set('RMT', $token, $expire);
    }
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
  * @return \Phalcon\Http\Response
  */
  public function loginWithRememberMe()
  {
    $userID = $this->cookies->get('RMU')->getValue();
    $cookieToken = $this->cookies->get('RMT')->getValue();

    $user = Users::findFirstById($userID);
    if ($user) {

      $userAgent = $this->request->getUserAgent();
      $token = md5($user->email . $user->password . $userAgent);

      if ($cookieToken == $token) {

        $remember = RememberTokens::findFirst([
          'userID = ?0 AND token = ?1',
          'bind' => [
            $user->id,
            $token
          ]
        ]);
        if ($remember) {

          // Check if the cookie has not expired
          if ((time() - (86400 * 8)) < $remember->createdAt) {

            // Check if the user was flagged
            $this->checkUserFlags($user);

            // Register identity
            $this->session->set('auth-identity', [
              'id' => $user->id,
              'name' => $user->name,
              'role' => $user->role->name
            ]);

            // Register the successful login
            $this->saveSuccessLogin($user);

            return $this->response->redirect('users');
          }
        }
      }
    }

    $this->cookies->get('RMU')->delete();
    $this->cookies->get('RMT')->delete();

    return $this->response->redirect('session/login');
  }

  /**
  * Checks if the user is inactive
  *
  * @param \Vokuro\Models\Users $user
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
  * Returns the current identity
  *
  * @return array
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

  public function getEmail()
  {
    $identity = $this->session->get('auth-identity');
    return $identity['email'];
  }

  public function getRole()
  {
    $identity = $this->session->get('auth-identity');
    return $identity['role'];
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

      $userID = $this->findFirstByToken($token);
      if ($userID) {
        $this->deleteToken($userID);
      }

      $this->cookies->get('RMT')->delete();
    }

    $this->session->remove('auth-identity');
  }

  /**
  * Auths the user by his/her id
  *
  * @param int $id
  * @throws Exception
  */
  public function authUserById($id)
  {
    $user = Users::findFirstById($id);
    if ($user == false) {
      throw new Exception('The user does not exist');
    }

    $this->checkUserFlags($user);

    $this->session->set('auth-identity', [
      'id' => $user->id,
      'name' => $user->name,
      'role' => $user->role->name
    ]);
  }

  /**
  * Get the entity related to user in the active identity
  *
  * @return \Vokuro\Models\Users
  * @throws Exception
  */
  public function getUser()
  {
    $identity = $this->session->get('auth-identity');
    if (isset($identity['id'])) {

      $user = Users::findFirstById($identity['id']);
      if ($user == false) {
        throw new Exception('The user does not exist');
      }

      return $user;
    }

    return false;
  }

  /**
  * Returns the current token user
  *
  * @param string $token
  * @return boolean
  */
  public function findFirstByToken($token)
  {
    $userToken = RememberTokens::findFirst([
      'conditions' => 'token = :token:',
      'bind'       => [
        'token' => $token,
      ],
    ]);

    $user_id = ($userToken) ? $userToken->userID : false;
    return $user_id;
  }

  /**
  * Delete the current user token in session
  */
  public function deleteToken($userID)
  {
    $user = RememberTokens::find([
      'conditions' => 'userID = :userID:',
      'bind'       => [
        'userID' => $userID
      ]
    ]);

    if ($user) {
      $user->delete();
    }
  }
}
