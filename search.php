<?php
require 'db.php';
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM people WHERE 
    last_name LIKE ? OR 
    husband_name LIKE ? OR 
    id_number LIKE ? OR 
    wife_id_number LIKE ? OR 
    address LIKE ? OR 
    floor LIKE ? OR 
    city LIKE ? OR 
    phone LIKE ? OR 
    husband_mobile LIKE ? OR 
    wife_name LIKE ? OR 
    wife_mobile LIKE ?";

$stmt = $pdo->prepare($sql);
$searchParam = "%" . $search . "%";
$params = array_fill(0, 11, $searchParam);

$stmt->execute($params);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['husband_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
    echo "<td>" . htmlspecialchars($row['wife_id_number']) . "</td>";
    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
    echo "<td>" . htmlspecialchars($row['floor']) . "</td>";
    echo "<td>" . htmlspecialchars($row['city']) . "</td>";
    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
    echo "<td>" . htmlspecialchars($row['husband_mobile']) . "</td>";
    echo "<td>" . htmlspecialchars($row['wife_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['wife_mobile']) . "</td>";
    echo "</tr>";
}
?>