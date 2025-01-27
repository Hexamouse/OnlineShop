<?php
session_start();
include('includes/db.php'); // Database connection

// Get the voucher code from the request
if (isset($_POST['voucher_code'])) {
    $voucher_code = $_POST['voucher_code'];
    
    // Check if the voucher code exists in the database
    $query = "SELECT * FROM vouchers WHERE code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $voucher_code);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Voucher found, get the discount percentage
        $voucher = $result->fetch_assoc();
        $discount_percentage = $voucher['discount_percentage'];
        
        // Check if the voucher is still valid (optional, based on expiry date or usage limit)
        $current_date = date('Y-m-d');
        if ($current_date <= $voucher['expiry_date'] && $voucher['usage_limit'] > 0) {
            // Apply the discount
            $response = [
                'success' => true,
                'discount_percentage' => $discount_percentage
            ];

            // Optionally, reduce the usage limit by 1 (if applicable)
            $update_query = "UPDATE vouchers SET usage_limit = usage_limit - 1 WHERE code = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("s", $voucher_code);
            $update_stmt->execute();
        } else {
            // Voucher expired or usage limit reached
            $response = [
                'success' => false,
                'error' => 'Voucher has expired or reached usage limit.'
            ];
        }
    } else {
        // Voucher not found
        $response = [
            'success' => false,
            'error' => 'Invalid voucher code.'
        ];
    }

    // Return the response as JSON
    echo json_encode($response);
}
else {
    // Voucher code not provided
    echo json_encode([
        'success' => false,
        'error' => 'Voucher code is required.'
    ]);
}
?>