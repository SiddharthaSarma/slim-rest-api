<?php

$app = new \Slim\App();

// Get individual customer details.
$app->get('/api/customers/{id}', function ($request, $response, $args) {
    try {
        $customerId = $request->getAttribute('id');
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $sql = 'SELECT * FROM CUSTOMERS where id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $customerId);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($customer);
    } catch (PDOException $e) {
        echo json_encode($e);
    }
});


//  Get whole customer list.
$app->get('/api/customers', function ($request, $response, $args) {
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $sql = 'SELECT * FROM CUSTOMERS';
        $result = $conn->query($sql);
        $customers = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($customers);
    } catch (PDOException $e) {
        echo json_encode($e);
    }
});


//  Adding new customer to the database.
$app->post('/api/customers/add', function ($request, $response, $args) {
    $requestObj = $request->getParsedBody();
    $firstName = $requestObj['first_name'];
    $lastName = $requestObj['last_name'];
    $phone = $requestObj['phone'];
    $email = $requestObj['email'];
    $address = $requestObj['address'];
    $city = $requestObj['city'];
    $state = $requestObj['state'];
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $sql = 'INSERT INTO CUSTOMERS(first_name, last_name, phone, email, address, city, state) VALUES (
                        :first_name, :last_name, :phone, :email, :address,  :city, :state
)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':state', $state);
        echo json_encode($stmt->execute());
    } catch (PDOException $e) {
        echo json_encode($e);
    }
});
// To update the customer details.
$app->put('/api/customers/update/{id}', function ($request, $response, $args) {
    $customerId = $args['id'];
    $requestObj = $request->getParsedBody();
    $firstName = $requestObj['first_name'];
    $lastName = $requestObj['last_name'];
    $phone = $requestObj['phone'];
    $email = $requestObj['email'];
    $address = $requestObj['address'];
    $city = $requestObj['city'];
    $state = $requestObj['state'];
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $sql = 'UPDATE CUSTOMERS
                SET
                first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                email = :email,
                address = :address,
                city = :city,
                state = :state
                WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':state', $state);
        $stmt->bindValue('id', $customerId);
        echo json_encode($stmt->execute());
    } catch (PDOException $e) {
        echo json_encode($e);
    }
});

// Delete customers based on the customer id.
$app->delete('/api/customers/delete/{id}', function ($request, $response, $args) {
    $customerId = $args['id'];
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $sql = 'DELETE FROM CUSTOMERS WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $customerId);
        echo(json_encode($stmt->execute()));
    } catch (PDOException $e) {
        echo json_encode($e);
    }
});