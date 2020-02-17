<?php

namespace App\Firebase;

// use Illuminate\Http\Request;
// use Firebase\Auth\Token\Verifier;
use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;

class Guard
{
    // protected $verifier;

    // public function __construct(IdTokenVerifier $IdTokenVerifier)
    // {
    //     $this->verifier = IdTokenVerifier::createWithProjectId('amigo-af350');
    // }

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    public function user($request)
    {
        $token = $request->bearerToken();
        $verifier = IdTokenVerifier::createWithProjectId('amigo-af350');
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

        // $projectId = 'amigo-af350';
        // // $idToken = 'eyJhb...'; // An ID token given to your backend by a Client application

        // $verifier = IdTokenVerifier::createWithProjectId($projectId);

        // try {
        //     $token = $verifier->verifyIdToken($request->token);
        // } catch (IdTokenVerificationFailed $e) {
        //     echo $e->getMessage();
        //     // Example Output:
        //     // The value 'eyJhb...' is not a verified ID token:
        //     // - The token is expired.
        //     exit;
        // }

        // try {
        //     $token = $verifier->verifyIdTokenWithLeeway($request->token, $leewayInSeconds = 10000000);
        // } catch (IdTokenVerificationFailed $e) {
        //     print $e->getMessage();
        //     exit;
        // }

        // echo json_encode($token->payload(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}