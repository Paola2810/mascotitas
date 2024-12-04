<?php
header("Content-Type: application/json");

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=localhost;dbname=mascotitas", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos enviados por el cliente
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar que los datos estén presentes
    if (!isset($data["fecha"], $data["hora"], $data["metodo"])) {
        echo json_encode(["success" => false, "message" => "Faltan datos."]);
        exit;
    }

    // Insertar datos en la base de datos
    $stmt = $pdo->prepare("INSERT INTO registros (fecha, hora, metodo) VALUES (:fecha, :hora, :metodo)");
    $stmt->bindParam(":fecha", $data["fecha"]);
    $stmt->bindParam(":hora", $data["hora"]);
    $stmt->bindParam(":metodo", $data["metodo"]);
    $stmt->execute();

    // Respuesta de éxito
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    // Respuesta de error
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
