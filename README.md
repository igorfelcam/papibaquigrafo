# Papibaquigrafo

Clone and run, simple as that!

## Attention ⚠️

Run command:
```bash
docker-compose up -d
```
And access the address in your browser:
```
http://localhost:8080/
```

To use test database, run:
```bash
php artisan migrate
```
```bash
php artisan db:seed
```

To process the queue that sends the transfer notification to the user, run:
```bash
php artisan queue:listen
```
---
## Diagrams 🤯

Some flow diagrams can help you to understand the application proposal.

### Transfers Flow
![Transfers flow](docs/diagrams-transfers-flow.jpg "Transfers flow")

### Activities Flow
![Activities Flow](docs/diagrams-activities-flow.jpg "Activities Flow")

### Activities Diagram
![Activities Diagram](docs/diagrams-activities-diagram.jpg "Activities Diagram")

### ER Diagram
![ER Diagram](docs/er-diagram.jpg "ER Diagram")

---
## Routes 🌎

|Method |Action                 |Params|
|-------|-----------------------|------------------|
|POST   |`.../values-transfers` |`user email payer`, `user email payee`, `value`|
|GET    |`.../transfers-details`|`user email`|

---
## Job 🕐

### NotificationJob

![Running Queue](docs/queue_proccess.jpg "Running Queue")
---
## Middleware 🔞

### TransferAuthMiddleware

---
## Rules ✔️

### EmailRule
### ValueRule

---
## Controllers 🎮

### TransferController
- valuesTransfers()
- transfersDetails()
---
## Services 💰

### TransferAuthService
- hasTransferAuth()

### WalletService
- hasBalanceToValue($value)
- sendValue($value, $payer, $payee)

---
## Repositories 🔍
### WalletRepository
- updateValue($owner, $value)

### TransferLogRepository

---
## Models 💾
### User

### Wallet

### TransferLog
