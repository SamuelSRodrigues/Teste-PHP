<?php
function fetchAll($pdo, $query, $params = []) {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function executeQuery($pdo, $query, $params = []) {
    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}
?>
