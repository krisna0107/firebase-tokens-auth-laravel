<?php

namespace App\Firebase;

// use Illuminate\Http\Request;
// use Firebase\Auth\Token\Verifier;
use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;

class Guard
{
    public function user($request)
    {
        $projectAmigoid = 'amigo-test-ed578';
        $projectid = 'amigo-af350';
        $token = $request->bearerToken();
        $verifier = IdTokenVerifier::createWithProjectId($projectid);
        try {
            // $token = $this->verifier->verifyIdToken($token);
            $token = $verifier->verifyIdToken($token);
            echo json_encode($token->payload(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            // return new User($token->getClaims());
        }
        catch (\Exception $e) {
            print $e->getMessage();
            return;
        }

        try {
            $token = $verifier->verifyIdTokenWithLeeway($token, $leewayInSeconds = 10000000);
        } catch (IdTokenVerificationFailed $e) {
            print $e->getMessage();
            exit;
        }
    }
}