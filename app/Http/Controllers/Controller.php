<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController {
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handles the response for validation failures.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @param string $webMessage
     * @param string $apiMessage
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function handleValidationFailure(\Illuminate\Validation\Validator $validator, string $webMessage, string $apiMessage = "Validation failed") {
        if (API_RESPONSE) {
            return response()->json([
                'status' => "error",
                'message' => $apiMessage,
                'errors' => $validator->errors(),
            ], 422);
        }
        return redirect()->back()->with('error', $webMessage)->withErrors($validator)->withInput();
    }

    /**
     * Validates the given data against the provided validation rules.
     *
     * @param array $data The data to validate.
     * @param array $validationRules The validation rules.
     * @param array $customMessages Custom validation messages.
     * @return bool|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function validate($data, $validationRules, $customMessages = []) {
        // Validate the request
        $validator = Validator::make($data, $validationRules, $customMessages);

        // Check if the validation fails
        if ($validator->fails()) {
            return $this->handleValidationFailure($validator, 'A field did not meet the requirements', 'Validation failed');
        }

        // Clear any previous errors
        session()->forget(['errors', 'success', 'info', 'warning']);

        return true;
    }
}
