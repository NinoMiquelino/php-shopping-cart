<?php
require_once 'CartManager.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$response = ['success' => false, 'data' => null, 'error' => ''];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Tenta carregar o CartManager. Se falhar (ex: products.json não existe), retorna 500.
try {
    $manager = new CartManager();
} catch (Exception $e) {
    http_response_code(500);
    $response['error'] = 'Erro interno do servidor: ' . $e->getMessage();
    echo json_encode($response);
    exit;
}

$inputData = [];
if (in_array($method, ['POST', 'PUT'])) {
    $input = file_get_contents('php://input');
    $inputData = json_decode($input, true) ?? [];
}

try {
    // Roteamento
    switch ($method) {
        case 'GET':
            // Rota 1: /api.php?action=catalog (Retorna todos os produtos)
            if (isset($_GET['action']) && $_GET['action'] === 'catalog') {
                $response['data'] = $manager->getCatalog();
            
            // Rota 2: /api.php (Retorna o resumo do carrinho)
            } else {
                $response['data'] = $manager->getCartSummary();
            }
            break;

        case 'POST':
            // POST /api.php (Adicionar item) - Espera { product_id: X, quantity: Y }
            $id = $inputData['product_id'] ?? null;
            $qty = $inputData['quantity'] ?? 1;
            
            if (!$id) {
                throw new Exception("product_id é obrigatório para adicionar ao carrinho.", 400);
            }
            $response['data'] = $manager->addItem((int)$id, (int)$qty);
            break;
            
        case 'PUT':
            // PUT /api.php (Atualizar quantidade) - Espera { product_id: X, quantity: Y }
            $id = $inputData['product_id'] ?? null;
            $qty = $inputData['quantity'] ?? null;
            
            if (!$id || $qty === null) {
                throw new Exception("product_id e quantity são obrigatórios para atualizar.", 400);
            }
            $response['data'] = $manager->updateQuantity((int)$id, (int)$qty);
            break;

        case 'DELETE':
            // DELETE /api.php?id=X (Remover item)
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                // DELETE /api.php?action=clear (Limpar carrinho)
                if (isset($_GET['action']) && $_GET['action'] === 'clear') {
                    $response['data'] = $manager->clearCart();
                    break;
                }
                throw new Exception("ID do produto ou action=clear é obrigatório para DELETE.", 400);
            }
            $response['data'] = $manager->removeItem((int)$id);
            break;
            
        default:
            http_response_code(405);
            throw new Exception("Método não suportado.", 405);
    }
    
    $response['success'] = true;

} catch (Exception $e) {
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    $response['success'] = false;
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
