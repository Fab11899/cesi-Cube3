<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer',
                'name' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer|min:1',
            ]);

            $cart = session()->get('cart', []);
            $found = false;

            // Vérifie si le produit existe déjà dans le panier
            foreach ($cart as &$item) {
                if ($item['product_id'] === $request->product_id) {
                    $item['quantity'] += $request->quantity;
                    $found = true;
                    break;
                }
            }

            unset($item); // Sécurité après foreach avec référence

            // Si non trouvé, on l'ajoute
            if (!$found) {
                $cart[] = [
                    'product_id' => $request->product_id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                ];
            }

            session()->put('cart', $cart);

            return response()->json(['message' => 'Ajouté au panier', 'cart' => $cart]);

        } catch (\Throwable $e) {
            \Log::error('Erreur panier : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur interne', 'detail' => $e->getMessage()], 500);
        }
    }
    public function getCart()
    {
        $cart = session()->get('cart', []);

        // Convertir en tableau avec product_id dans chaque item


        return response()->json($cart);
    }
    public function removeFromCart($id)
    {
        try {
            $cart = session()->get('cart', []);

            $cart = array_filter($cart, function ($item) use ($id) {
                return $item['product_id'] != $id;
            });

            $cart = array_values($cart); // Réindexe le tableau
            session()->put('cart', $cart);

            return response()->json(['message' => 'Produit retiré', 'cart' => $cart]);
        } catch (\Throwable $e) {
            \Log::error('Erreur suppression panier : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur interne', 'detail' => $e->getMessage()], 500);
        }
    }


}

