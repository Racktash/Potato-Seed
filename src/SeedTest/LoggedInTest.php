<?php
define("REGISTRY_COOKIES_USER", "ps_user");
define("REGISTRY_COOKIES_SESSION", "ps_session");
require_once 'Seed/entities/LoggedIn.php';

class LoggedInTest extends PHPUnit_Framework_TestCase
{
    private function prepareLoggedIn()
    {
        LoggedIn::reset();
    }

    private function generateFakeCookieArray($userid, $session)
    {
        $f_array[REGISTRY_COOKIES_USER] = $userid;
        $f_array[REGISTRY_COOKIES_SESSION] = $session;

        return $f_array;
    }
    
    public function test_isLoggedIn_NoCookies_ReturnsFalse()
    {
        $this->prepareLoggedIn();
        $fake_cookie_array = array();
        LoggedIn::setCookiesArray($fake_cookie_array);

        $this->assertFalse(LoggedIn::isLoggedIn());
    }
    
    public function test_isLoggedIn_NullUserIDCookie_ReturnsFalse()
    {
        $this->prepareLoggedIn();
        $fake_cookie_array = $this->generateFakeCookieArray(null, "10.10");
        LoggedIn::setCookiesArray($fake_cookie_array);

        $this->assertFalse(LoggedIn::isLoggedIn());
    }
    
    public function test_isLoggedIn_NullSessionCookie_ReturnsFalse()
    {
        $this->prepareLoggedIn();
        $fake_cookie_array = $this->generateFakeCookieArray(1, null);
        LoggedIn::setCookiesArray($fake_cookie_array);

        $this->assertFalse(LoggedIn::isLoggedIn());
    }
    
    public function test_isLoggedIn_EmptyUserIDCookie_ReturnsFalse()
    {
        $this->prepareLoggedIn();
        $fake_cookie_array = $this->generateFakeCookieArray("", "10.10");
        LoggedIn::setCookiesArray($fake_cookie_array);

        $this->assertFalse(LoggedIn::isLoggedIn());
    }
    
    public function test_isLoggedIn_EmptySessionCookie_ReturnsFalse()
    {
        $this->prepareLoggedIn();
        $fake_cookie_array = $this->generateFakeCookieArray(1, "");
        LoggedIn::setCookiesArray($fake_cookie_array);

        $this->assertFalse(LoggedIn::isLoggedIn());
    }
}
?>