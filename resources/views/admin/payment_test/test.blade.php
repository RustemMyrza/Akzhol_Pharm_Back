<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://test-epay.homebank.kz/payform/payment-api.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .button-container {
            text-align: center;
        }

        .pay-button {
            padding: 16px 32px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .pay-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button class="pay-button" onclick="initiatePayment()">Pay Now (Test)</button>
    </div>
<script>
    function createPaymentObject(auth, invoiceId, amount) {
        return {
            invoiceId: invoiceId,
            invoiceIdAlt: invoiceId,
            backLink: "https://back-akzhol.test-nomad.kz/admin/success",
            failureBackLink: "https://back-akzhol.test-nomad.kz/admin/failure",
            postLink: "https://back-akzhol.test-nomad.kz/admin/post-link",
            failurePostLink: "https://back-akzhol.test-nomad.kz/admin/failure-post-link",
            language: "RUS",
            description: "Оплата в интернет магазине",
            accountId: "testuser1",
            terminal: "67e34d63-102f-4bd1-898e-370781d0074d",
            amount: amount,
            name: "Arman Ali",
            currency: "KZT",
            data: JSON.stringify({ statement: { name: "Arman Ali", invoiceID: invoiceId } }),
            cardSave: true,
            auth: auth
        };
    }

    function callBk(response) {
        if (response.success) {
            alert('Платеж успешно завершен');
        } else {
            alert('Ошибка при проведении платежа');
        }
    }

    function initiatePayment() {
        var auth = {
            access_token: "{{ $token }}", // Токен, который ты получил
            expires_in: 1200,
            token_type: "Bearer"
        };
        var invoiceId = "000001"; // Уникальный номер заказа
        var amount = 100; // Сумма заказа

        halyk.showPaymentWidget(createPaymentObject(auth, invoiceId, amount), callBk);
    }
</script>

</body>
</html>
