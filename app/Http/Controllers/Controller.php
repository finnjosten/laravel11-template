<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
        $customMessages = array_merge([
            'g-recaptcha-response' => [ 'recaptchav3' => 'Recaptcha failed! your score is most likely to low. Navigate over the site a bit and try again.', ],
        ], $customMessages);

        // Validate the request
        $validator = Validator::make($data, $validationRules, $customMessages);

        // Check if the validation fails
        if ($validator->fails()) {
            return [
                'success' => false,
                'redirect' => $this->handleValidationFailure($validator, 'A field did not meet the requirements')
            ];
        }

        // Clear any previous errors
        session()->forget(['errors', 'success', 'info', 'warning']);

        return [
            'success' => true,
            'redirect' => null,
            'data' => $data
        ];
    }













    /**
     * Check if the user has the required permissions
     *
     * @param Array $permissions Array of permissions required to perform the action
     * @param bool $use_response If true, will return a JSON response with an error message if the user does not have permission
     *                          If false, will return false if the user does not have permission
     * @return bool
     */
    public function checkPermission(array $permissions, bool $use_response = true): bool {
        $rolePerms = Request::user()->role->permissions;

        // Check each required permission
        foreach ($permissions as $requiredPerms) {
            if (!$this->hasPermission($rolePerms, $requiredPerms)) {
                return $this->deny($use_response);
            }
        }

        return true;
    }



    /**
     * Check if user roles grant access to a specific permission
     *
     * @param array $userRoles Array of role permissions from user's role
     * @param string $requiredPermission The permission to check
     * @return bool
     */
    private function hasPermission(array $userRoles, string $requiredPermission): bool {
        // Handle negation permissions first - if role has !* or * with !<action>
        foreach ($userRoles as $role) {
            // Check for global deny (!*)
            if ($role === '!*') {
                return false;
            }

            // Check for specific action deny (!<action>)
            if ($role === '!' . $requiredPermission) {
                return false;
            }

            // Check for wildcard with specific deny (e.g., "*, !someaction")
            if ($role === '*' && in_array('!' . $requiredPermission, $userRoles)) {
                return false;
            }
        }

        foreach ($userRoles as $role) {
            // Rule 1: If role has <group>.* and permission is <group>.<action> - ALLOW
            if (str_ends_with($role, '.*')) {
                $rolePrefix = substr($role, 0, -2); // Remove .*
                if (str_starts_with($requiredPermission, $rolePrefix . '.')) {
                    // Check if it's exactly one level deeper
                    $remaining = substr($requiredPermission, strlen($rolePrefix) + 1);
                    if (strpos($remaining, '.') === false) {
                        return true;
                    }
                }
            }

            // Rule 2: If role has <group>.<subgroup>.* and permission is <group>.<subgroup>.<action> - ALLOW
            if (str_ends_with($role, '.*')) {
                $rolePrefix = substr($role, 0, -2);
                if ($requiredPermission === $rolePrefix || str_starts_with($requiredPermission, $rolePrefix . '.')) {
                    // Check if it's exactly the same level
                    if ($requiredPermission === $rolePrefix) {
                        return true;
                    }
                    $remaining = substr($requiredPermission, strlen($rolePrefix) + 1);
                    if (strpos($remaining, '.') === false) {
                        return true;
                    }
                }
            }

            // Rule 3: If role has <group>.* and permission is <group>.<subgroup>.<action> - ALLOW (iterator_apply)
            if (str_ends_with($role, '.*')) {
                $rolePrefix = substr($role, 0, -2);
                if (str_starts_with($requiredPermission, $rolePrefix . '.')) {
                    return true; // Allow deeper nesting
                }
            }

            // Rule 4: If role has <group>.<subgroup>.* and permission is <group>.<action> - DENY
            if (str_ends_with($role, '.*')) {
                $rolePrefix = substr($role, 0, -2);
                $roleParts = explode('.', $rolePrefix);
                $permParts = explode('.', $requiredPermission);

                if (count($roleParts) > count($permParts)) {
                    // Role is more specific than permission - check if they share the same base
                    $roleBase = implode('.', array_slice($roleParts, 0, count($permParts)));
                    if ($roleBase === implode('.', $permParts)) {
                        return false; // DENY - more specific role trying to access less specific permission
                    }
                }
            }

            // Exact match
            if ($role === $requiredPermission) {
                return true;
            }

            // Global wildcard
            if ($role === '*') {
                return true;
            }
        }

        return false; // Default deny
    }



    /**
     * Handle permission denial
     *
     * @param bool $use_response Whether to send HTTP response or just return false
     * @return bool Always returns false
     */
    private function deny(bool $use_response): bool|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse {
        if ($use_response) {
            if (API_RESPONSE) {
                return response()->json([
                    "status" => "error",
                    "code" => "not_enough_permissions",
                    "message" => "You do not have the required permissions to perform this action."
                ], 401);
                exit;
            }
            return redirect()->back()->with('error', "You do not have the required permissions to perform this action.")->withInput();
        }
        return false;
    }



    /**
     * Helper method to check a single permission (for convenience)
     *
     * @param string $permission Single permission to check
     * @param bool $use_response Whether to use HTTP response on failure
     * @return bool
     */
    public function checkSinglePermission(string $permission, bool $use_response = true): bool {
        return $this->checkPermission([$permission], $use_response);
    }
}
