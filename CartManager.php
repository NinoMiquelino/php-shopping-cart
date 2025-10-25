<?php

class CartManager {
    private array $products; // Catálogo de produtos
    
    // Nome da chave na $_SESSION
    private const SESSION_KEY = 'shopping_cart'; 

    public function __construct() {
        // 1. Inicia a sessão (essencial para persistência)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Carrega o catálogo de produtos
        $this->loadProducts();

        // 3. Garante que a chave do carrinho exista na sessão
        if (!isset($_SESSION[self::SESSION_KEY]) || !is_array($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    /**
     * Carrega o catálogo de produtos do arquivo JSON.
     */
    private function loadProducts(): void {
        $jsonFile = __DIR__ . '/products.json';
        if (!file_exists($jsonFile)) {
            throw new Exception("Catálogo de produtos (products.json) não encontrado.");
        }
        $data = file_get_contents($jsonFile);
        $this->products = json_decode($data, true) ?: [];
    }
    
    /**
     * Busca um produto no catálogo pelo ID.
     */
    private function getProductDetails(int $id): ?array {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    // --- MÉTODOS PÚBLICOS DE GERENCIAMENTO ---

    /**
     * Adiciona um item ao carrinho ou aumenta a quantidade.
     */
    public function addItem(int $productId, int $quantity = 1): array {
        $productDetails = $this->getProductDetails($productId);

        if (!$productDetails) {
            throw new Exception("Produto ID {$productId} não encontrado no catálogo.", 404);
        }

        $cart = $_SESSION[self::SESSION_KEY];
        
        // Verifica se o produto já está no carrinho
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Adiciona o novo produto (apenas dados essenciais para o carrinho)
            $cart[$productId] = [
                'id' => $productId,
                'name' => $productDetails['name'],
                'price' => $productDetails['price'],
                'image' => $productDetails['image'],
                'quantity' => $quantity
            ];
        }

        $_SESSION[self::SESSION_KEY] = $cart;
        return $this->getCartSummary();
    }

    /**
     * Remove completamente um item do carrinho.
     */
    public function removeItem(int $productId): array {
        $cart = $_SESSION[self::SESSION_KEY];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $_SESSION[self::SESSION_KEY] = $cart;
        }
        return $this->getCartSummary();
    }

    /**
     * Atualiza a quantidade de um item específico.
     */
    public function updateQuantity(int $productId, int $newQuantity): array {
        $cart = $_SESSION[self::SESSION_KEY];
        
        if (!isset($cart[$productId])) {
             throw new Exception("Produto não está no carrinho.", 404);
        }

        if ($newQuantity <= 0) {
            return $this->removeItem($productId); // Remove se a quantidade for 0 ou menos
        }

        $cart[$productId]['quantity'] = $newQuantity;
        $_SESSION[self::SESSION_KEY] = $cart;
        
        return $this->getCartSummary();
    }

    /**
     * Limpa o carrinho.
     */
    public function clearCart(): array {
        $_SESSION[self::SESSION_KEY] = [];
        return $this->getCartSummary();
    }

    /**
     * Retorna o resumo completo do carrinho (itens, total, contagem).
     */
    public function getCartSummary(): array {
        $cart = $_SESSION[self::SESSION_KEY];
        $total = 0.0;
        $itemCount = 0;

        foreach ($cart as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            $itemCount += $item['quantity'];
        }

        return [
            'items' => array_values($cart), // Retorna como array sequencial
            'total' => round($total, 2),
            'item_count' => $itemCount
        ];
    }
    
    /**
     * Retorna o catálogo completo de produtos para a vitrine.
     */
     public function getCatalog(): array {
         return $this->products;
     }
}
