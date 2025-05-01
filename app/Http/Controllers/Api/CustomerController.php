<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Mail\PasswordResetMail;
use App\Mail\VerificationCodeMail;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
class CustomerController extends Controller
{


    public function register(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'phone' => 'required|string',
                'gender' => 'required|string',
                'email' => 'required|string|email|min:15',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $existingCustomer = Customer::query()->where('email', $request->email)->first();

            if ($existingCustomer) {
                if (!$existingCustomer->email_verified_at) {
                    $verificationCode = rand(100000, 999999);
                    $uuidToken = Str::uuid()->toString();

                    $existingCustomer->update([
                        'email_verification_code' => $verificationCode,
                        'email_verification_token' => $uuidToken,
                    ]);

                    Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));

                    return response()->json([
                        'message' => 'Email is already registered but not verified. Verification email has been resent.',
                        'token' => $uuidToken
                    ], 200);
                }

                return response()->json([
                    'error' => 'Email is already registered.'
                ], 422);

            }

            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
            ]);

            $verificationCode = rand(100000, 999999);
            $uuidToken = Str::uuid()->toString();

            $customer->update([
                'email_verification_code' => $verificationCode,
                'email_verification_token' => $uuidToken,
            ]);

            Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));

            return response()->json([
                'message' => 'Registration successful. Please verify your email.',
                'token' => $uuidToken
            ], 201);

        }catch (\Exception $exception){

            \Log::error('Password Reset Email Error: ' . $exception->getMessage());
            return response()->json([
                'message' => 'Registration successful. Please verify your email.',
                'token' => $uuidToken
            ], 201);

        }

    }


    public function verifyEmail(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|integer',
            'verification_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $customer = Customer::query()->where('email_verification_token', $request->verification_token)
            ->where('email_verification_code', $request->verification_code)
            ->first();

        if (!$customer) {
            return response()->json(['message' => 'Invalid verification code or token'], 400);
        }

        $customer->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
            'email_verification_token' => null,
            'is_active' => true,
        ]);

        return response()->json(['message' => 'Email successfully verified.']);

    }


    public function update(Request $request): JsonResponse
    {
        try {

            $customer = Customer::query()->findOrFail(auth()->user()->id);

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'phone' => 'required|max:20',
                'gender' => 'nullable|max:20',
                'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
                'password' => 'nullable|string',
                'new_password' => 'nullable|string|min:4|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->all()
                ], 422);
            }

            if ($request->filled('new_password')) {
                if (!Hash::check($request->password, $customer->password)) {
                    return response()->json([
                        'errors' => ['password' => ['The current password is incorrect.']]
                    ], 422);
                }
            }

            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => $request->gender,
            ];

            if ($request->filled('new_password')) {
                $data['password'] = Hash::make($request->new_password);
            }

            $customer->update($data);

            return response()->json(new CustomerResource($customer), 200);

        }catch (\Exception $exception){
            \Log::error('Password Reset Email Error: ' . $exception->getMessage());
            return response()->json(new CustomerResource($customer), 200);
        }

    }


    public function login(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $customer = Customer::query()->where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$customer->is_active) {
            return response()->json(['message' => 'Please verify your email address.'], 401);
        }

        if ($customer->is_blocked) {
            return response()->json(['message' => 'Your account has been blocked. Please contact support.'], 401);
        }

        $token = $customer->createToken('admin_token')->plainTextToken;

        return response()->json(['token' => $token, 'customer' => new CustomerResource($customer)]);

    }

    public function logout(Request $request): JsonResponse
    {

        $customer = $request->user();

        if ($customer) {
            $customer->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'No authenticated user found'], 401);

    }

    public function requestEmailChange(Request $request): JsonResponse
    {

        try {
            $validator = Validator::make($request->all(), [
                'new_email' => 'required|string|email|unique:customers,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->all()
                ], 422);
            }

            $customer = auth()->user();
            $verificationCode = rand(100000, 999999);

            $customer->update(['email_verification_code' => $verificationCode]);

            Mail::to($request->new_email)->send(new VerificationCodeMail($verificationCode));
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }

        return response()->json(['message' => 'Verification code sent to the new email']);

    }

    public function verifyEmailChange(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'new_email' => 'required|string|email|unique:customers,email',
            'verification_code' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $customer = auth()->user();

        if ($customer->email_verification_code != $request->verification_code) {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }

        $customer->update([
            'email' => $request->new_email,
            'email_verification_code' => null,
        ]);



        return response()->json([
            'message' => 'Email updated successfully',
            'customer' => new CustomerResource($customer)
        ]);

    }

    public function requestPasswordReset(Request $request): JsonResponse
    {

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|exists:customers,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->all()
                ], 422);
            }


            $customer = Customer::query()->where('email', $request->email)->first();

            if(!$customer->email_verified_at){
                return response()->json([
                    'errors' => 'Emailinizi təsdiqləyin'
                ], 422);
            }

            $resetToken = Str::random(60);

            $customer->update([
                'password_reset_token' => $resetToken,
                'password_reset_token_expiry' => now()->addHours(1),
            ]);

            $resetUrl =  'https://brendoo.com/en' . '/password-reset/' . $resetToken;

            Mail::to($customer->email)->send(new PasswordResetMail($resetUrl));

            return response()->json(['message' => 'Password reset link sent to your email']);
        } catch (\Exception $exception) {
            \Log::error('Password Reset Email Error: ' . $exception->getMessage());
            return response()->json(['error' => 'Failed to send email.'], 500);
        }

    }

    public function resetPassword(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:customers,email',
            'reset_token' => 'required',
            'new_password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $customer = Customer::query()->where('email', $request->email)->first();

        if ($customer->password_reset_token != $request->reset_token) {
            return response()->json(['message' => 'Invalid reset token'], 400);
        }

        $customer->update([
            'password' => Hash::make($request->new_password),
            'password_reset_token' => null,
        ]);

        return response()->json(['message' => 'Password updated successfully']);

    }


    public function registerGoogle(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'token' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->all()
                ], 422);
            }

            // Verify the token with Google's API
            $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $request->token,
            ]);

            if ($response->failed() || !$response->json('email')) {
                return response()->json(['message' => 'Invalid token or unable to retrieve user information.'], 400);
            }

            // Extract user info from the response
            $googleUser = $response->json();
            $email = $googleUser['email'];
            $name = $googleUser['name'] ?? 'Unknown';

            // Check if the user already exists
            $existingCustomer = Customer::query()->where('email', $email)->first();

            if ($existingCustomer) {
                return response()->json([
                    'message' => 'User already exists.',
                    'token' => $existingCustomer->createToken('admin_token')->plainTextToken,
                    'customer' => new CustomerResource($existingCustomer),
                ], 422);
            }

            // Create a new customer
            $customer = Customer::create([
                'name' => $name,
                'email' => $email,
                'phone' => '',
                'gender' => '',
                'password' => Str::password(),
                'is_active' => true,
            ]);

            return response()->json([
                'message' => 'Registration successful.',
                'token' => $customer->createToken('admin_token')->plainTextToken,
                'customer' => new CustomerResource($customer),
            ], 201);
        } catch (\Exception $exception) {
            \Log::error('Google Registration Error: ' . $exception->getMessage());
            return response()->json(['message' => 'An error occurred during registration.'], 500);
        }
    }

    public function loginGoogle(Request $request): JsonResponse
    {
//        $validator = Validator::make($request->all(), [
//            'token' => 'required|string',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'errors' => $validator->errors()->all()
//            ], 422);
//        }
//
//        // Verify the token with Google's API
//        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
//            'id_token' => $request->token,
//        ]);

//        return response()->json($response);
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'token' => 'required|string',
            ]);

//            if ($validator->fails()) {
//                return response()->json([
//                    'errors' => $validator->errors()->all()
//                ], 422);
//            }

            // Verify the token with Google's API
            $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $request->token,
            ]);

            if ($response->failed() || !$response->json('email')) {
                return response()->json(['message' => 'Invalid token or unable to retrieve user information.'], 400);

            }

            // Extract user information from Google's response
            $googleUser = $response->json();
            $email = $googleUser['email'];

            // Check if the customer exists
            $customer = Customer::query()->where('email', $email)->first();
            $email = $googleUser['email'];
            $name = $googleUser['name'] ?? 'Unknown';
            if (!$customer) {
//                return response()->json(['message' => 'No account found for this email.'], 404);
                $customer = Customer::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => '',
                    'gender' => '',
                    'password' => Str::password(),
                    'is_active' => true,
                ]);

                return response()->json([
                    'message' => 'Registration successful.',
                    'token' => $customer->createToken('admin_token')->plainTextToken,
                    'customer' => new CustomerResource($customer),
                ], 201);
            }

            // Check if the customer's account is active
//            if (!$customer->is_active) {
//                return response()->json(['message' => 'Please verify your email address.'], 401);
//            }

            // Check if the customer's account is blocked
            if ($customer->is_blocked) {
                return response()->json(['message' => 'Your account has been blocked. Please contact support.'], 401);
            }

            // Generate a token for the customer
            $token = $customer->createToken('admin_token')->plainTextToken;

            // Return success response with token and customer details
            return response()->json([
                'token' => $token,
                'customer' => new CustomerResource($customer)
            ]);
        } catch (\Exception $exception) {
            // Log the error for debugging
            \Log::error('Google Login Error: ' . $exception->getMessage());

            // Return a generic error response
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }



}

