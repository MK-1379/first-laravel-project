<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{

    public function store(Request $request)
    {
        $emailValidator = $this->validateEmail($request);
        $addressValidator = $this->validateAddress($request);

        if ($emailValidator->fails() || $addressValidator->fails()) {
            return response()->json([
                'message' => 'Failed',
                'email'   => $emailValidator->messages(),
                'address' => $addressValidator->messages(),
            ], 400);
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();

        if ($user->address) {
            return response()->json([
                'message' => 'Failed, UserAddress already exists',
                'data' => null
            ], 400);
        }

        $address = new Address($addressValidator->validate());

        if($user->address()->save($address)){
            return response()->json(['message' => 'Address saved', 'data' => $address], 200);
        }
        return response()->json(['message' => 'Failed', 'data' => null], 400);
    }

    public function index() {
        return response()->json(Address::all(), 200);
    }

    public function show(Address $address)
    {
        return response()->json(['message' => '', 'data' => $address], 200);
    }

    public function show_user(Address $address)
    {
        return response()->json(['message' => '', 'data' => $address->user], 200);
    }

    private function validateEmail(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email|max:255',
        ]);
    }
    private function validateAddress(Request $request)
    {
        return Validator::make($request->all(), [
            'country' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
        ]);
    }
}
