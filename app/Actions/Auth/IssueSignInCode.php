<?php

namespace App\Actions\Auth;

use App\Models\SignInCode;
use App\Models\User;
use Hashids\Hashids;

class IssueSignInCode
{
    private const EXPIRY_MINUTES = 15;

    public function __invoke(User $user): SignInCode
    {
        $hashids = new Hashids(config('app.key'), 6);
        $signature = $hashids->encode(random_int(0, PHP_INT_MAX));
        $code = str_pad((string) (crc32($signature) % 1000000), 6, '0', STR_PAD_LEFT);

        return $user->signInCodes()->create([
            'code' => $code,
            'expires_at' => now()->addMinutes(self::EXPIRY_MINUTES),
        ]);
    }
}
