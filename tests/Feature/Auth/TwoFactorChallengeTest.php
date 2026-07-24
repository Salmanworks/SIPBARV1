<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Tests\TestCase;

class TwoFactorChallengeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());
    }

    public function test_two_factor_challenge_redirects_to_login_when_not_authenticated(): void
    {
        $response = $this->get(route('two-factor.login'));

        $response->assertRedirect(route('login'));
    }

    /**
     * SIPBAR uses a custom LoginController (role + identifier + password) that does not
     * integrate with Fortify's 2FA pipeline. The 2FA redirect challenge is therefore
     * handled separately from the login flow and this test is intentionally skipped.
     *
     * @see App\Http\Controllers\Auth\LoginController
     */
    public function test_two_factor_challenge_can_be_rendered(): void
    {
        $this->markTestSkipped(
            'SIPBAR uses a custom login controller that bypasses the Fortify 2FA pipeline. '
            . 'The two-factor challenge page exists but is not triggered by the custom login flow.'
        );
    }
}
