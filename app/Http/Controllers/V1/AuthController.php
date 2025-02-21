<?php

namespace App\Http\Controllers\V1;

use App\Http\Resources\V1\Collection\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserCollection(User::all());
    }
    /**
     * Stocker un nouvel Utilisateur.
     *
     * @param \App\Http\Requests\V1\StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        
        DB::beginTransaction();
        try {
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar')->store('avatars');
            }
            $user = User::create($data);
            $token = $user->createToken("basic_token")->plainTextToken;
            DB::commit();
            return response()->json([
                "token" => $token,
                "user"  => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Échec de la création de l\'utilisateur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Authentifier un utilisateur et retourner un token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required', 'string']
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "Les informations d'identification fournies sont incorrectes"
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken("basic_token")->plainTextToken;
        return response()->json([
            "token" => $token,
            "user"  => new UserResource($user)
        ], 200);
    }

    /**
     * Déconnecter l'utilisateur en supprimant ses tokens.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            "message" => "Vous avez été déconnecté"
        ], 200);
    }

    /**
     * Retourner les informations de l'utilisateur authentifié.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json(new UserResource($request->user()));
    }

    /**
     * Afficher la ressource spécifiée.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Mettre à jour le profil d'un Utilisateur.
     *
     * @param \App\Http\Requests\V1\StoreUserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUserRequest $request, User $user){
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            Storage::delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars');
        }
        DB::beginTransaction();
        try {
            $user->update($data);
            DB::commit();
            return response()->json(new UserResource($user), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Échec de la mise à jour de l\'utilisateur'], 500);
        }
    }


}
