<?php

namespace App\Http\Middleware;

use Closure;
use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;

class AuthJWT
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('Authorization')) {
            return response()->json('Authorization Header not found', 401);
        }

        $token = $request->bearerToken();

        if($request->header('Authorization') == null || $token == null) {
            return response()->json('No token provided', 401);
        }

        $validation = $this->user($token);

        if ($validation !== true) 
        {
            return $validation;
        }

        return $next($request);
    }


    public function user($token)
    {
        // $projectAmigoid = 'amigo-test-ed578';
        $projectid = 'amigo-af350';
        // $token = $request->bearerToken();
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